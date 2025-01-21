<?php

namespace App\Http\Controllers;

use App\Mail\JobAplied;
use App\Models\Aplicant;
use App\Models\Job;
use Illuminate\Console\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AplicantController extends Controller
{
    public function store(Job $job): RedirectResponse
    {

        $existingAplicant = Aplicant::where('job_id', $job->id)->where('user_id', auth()->id())->exists();
        if ($existingAplicant) return back()->with('error', 'You already aplied to this job!');

        $validatedData = request()->validate([
            'full_name' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|string',
            'location' => 'string',
            'message' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        if (request()->hasFile('resume')) {
            $resume_path = request()->file('resume')->store('resumes', 'public');
            $validatedData['resume_path'] = $resume_path;
        }

        $applicant = new Aplicant($validatedData);
        $applicant->job_id = $job->id;
        $applicant->user_id = auth()->user()->id;
        $applicant->save();

        Mail::to($job->user->email)->send(new JobAplied($applicant, $job));

        return back()->with('success', 'Your application has been saved!');
    }

    public function destroy(Aplicant $aplicant): RedirectResponse
    {

        if (Storage::exists($aplicant->resume_path)) {
            Storage::delete($aplicant->resume_path);
        }
        $aplicant->delete();

        return back()->with('success', 'This application has been deleted!');
    }
}
