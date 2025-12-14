<?php
namespace App\Http\Controllers;

use App\Mail\ApplicationRejectedMail;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    // Public apply form
    public function create()
    {
        return Inertia::render('applications/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
             'email' => 'required|email|unique:applications',
            'phone' => 'required',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('applications', 'public');

        Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'cv_path' => $cvPath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    // Admin review page
   public function index()
{
    return Inertia::render('applications/Index', [
        'pendingApplications' => Application::where('status', 'pending')->latest()->get(),
        'acceptedApplications' => Application::where('status', 'accepted')->latest()->get(),
        'rejectedApplications' => Application::where('status', 'rejected')->latest()->get(),
        'flash' => session('success'),
    ]);
}


    // Update status (accept/reject)
     public function updateStatus(Request $request, Application $application)
    {
        $data = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'admin_note' => 'nullable|string'
        ]);

        $application->update([
            'status' => $data['status'],
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        // SEND MAIL ONLY WHEN REJECTED
        if ($data['status'] === 'rejected') {
            Mail::to($application->email)->send(
                new ApplicationRejectedMail(
                    $application->name,
                    $data['admin_note']
                )
            );
        }

        return back()->with('success', 'Application status updated');
    }
}
