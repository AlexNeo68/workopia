<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{

    use AuthorizesRequests;

    // @desc    Show all job listings
    // @route   GET /jobs
    public function index(): View
    {

        $title = 'Available jobs';
        $jobs = Job::latest()->paginate(9);
        return view('jobs.index', compact('title', 'jobs'));
    }

    // @desc    Show create job form
    // @route   GET /jobs/create
    public function create(): View
    {
        $title = 'Create Job';
        return view('jobs.create', compact('title'));
    }

    // @desc    Save job to database
    // @route   POST /jobs
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => ['required', 'boolean'],
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        $validatedData['user_id'] = auth()->id();

        if ($request->hasFile('company_logo')) {
            $validatedData['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        $job = Job::create($validatedData);

        return redirect()->route('jobs.show', $job->id)->with('success', 'JobListing created successfully!');
    }

    // @desc    Display a single job listing
    // @route   GET /jobs/{$id}
    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    // @desc    Show edit job form
    // @route   GET /jobs/{$id}/edit
    public function edit(Job $job): View
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));
    }

    // @desc    Update job listing
    // @route   PUT /jobs/{$id}
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => ['required', 'boolean'],
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        if ($request->hasFile('company_logo')) {

            Storage::delete($job->company_logo, 'logos', 'public');

            $validatedData['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        $job->update($validatedData);

        return redirect()->route('jobs.show', $job->id)->with('success', 'JobListing updated successfully!');
    }

    // @desc    Delete a job listing
    // @route   DELETE /jobs/{$id}
    public function destroy(Job $job): string
    {
        $this->authorize('update', $job);
        if ($job->company_logo) {
            Storage::delete("/public/logos/$job->company_logo");
        }
        $job->delete();

        $route = 'jobs.index';

        if (request()->query('from') == 'dashboard') {
            $route = 'dashboard.index';
        }

        return redirect()->route($route)->with('success', 'JobListing deleted successfully!');
    }
}
