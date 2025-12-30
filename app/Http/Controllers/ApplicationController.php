<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Jobs\SendApplicationRejectedMail;
use App\Models\Application;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index()
    {
        return Inertia::render('applications/Index', [
            'pendingApplications' => Application::where('status', 'pending')->latest()->get(),
            'acceptedApplications' => Application::where('status', 'accepted')->latest()->get(),
            'rejectedApplications' => Application::where('status', 'rejected')->latest()->get(),
            'flash' => session('success'),
        ]);
    }

    public function create()
    {
        return Inertia::render('applications/Create');
    }

    public function store(StoreApplicationRequest $request)
    {

        $cvPath = $request->file('cv')->store('applications', 'public');

        Application::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cv_path' => $cvPath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application)
    {
        $application->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note ?? null,
        ]);

        if ($request->status === 'rejected') {
            SendApplicationRejectedMail::dispatch(
                $application->name,
                $application->email,
                $request->admin_note
            );
        }

        return back()->with('success', 'Application status updated');
    }
}
