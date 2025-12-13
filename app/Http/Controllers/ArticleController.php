<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ArticleController extends Controller
{

      public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view articles')->only('index');
        $this->middleware('permission:create articles')->only(['create','store']);
        $this->middleware('permission:edit articles')->only(['edit','update']);
        $this->middleware('permission:delete articles')->only('destroy');
    }
  
    public function index()
    {
        $articles = Article::with('author:id,name')
            ->latest()
            ->paginate(10);

        return Inertia::render('articles/Index', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return Inertia::render('articles/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        Article::create([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(), // author
        ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article created successfully!');
    }

    public function edit(Article $article)
    {
        return Inertia::render('articles/Edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
        ]);

        $article->update($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
