<?php
namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ArticleController extends Controller
{

      public function __construct()
    {
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
            // dd($articles);

        return Inertia::render('articles/Index', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return Inertia::render('articles/Create');
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validate([
            'title'   => 'required|min:3',
            'content' => 'required|min:10',
        ]);

Article::create([
        'title'   => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id(),
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

    public function update(ArticleRequest $request, Article $article)
    {
       

      $article->update([
        'title'=>$request->title,
        'content'=>$request->content,
      ]);

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
