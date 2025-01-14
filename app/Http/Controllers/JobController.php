<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $title = 'Available jobs';
        $jobs = Job::all();
        return view('jobs.index', compact('title', 'jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Job';
        return view('jobs.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $validatedData['user_id'] = 1;

        if ($request->hasFile('company_logo')) {
            $validatedData['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        $job = Job::create($validatedData);

        return redirect()->route('jobs.show', $job->id)->with('success', 'JobListing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job): RedirectResponse
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

        $validatedData['user_id'] = 1;

        if ($request->hasFile('company_logo')) {

            Storage::delete($job->company_logo, 'logos', 'public');

            $validatedData['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        $job->update($validatedData);

        return redirect()->route('jobs.show', $job->id)->with('success', 'JobListing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): string
    {
        if ($job->company_logo) {
            Storage::delete("/public/logos/$job->company_logo");
        }
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'JobListing deleted successfully!');
    }
}
