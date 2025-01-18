<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index(): View
    {

        $bookmarks = $this->user->bookmarks()->latest()->get();
        return view('jobs.bookmarked', compact('bookmarks'));
    }

    public function store(Request $request, Job $job): RedirectResponse
    {

        if ($this->user->isBookmarkedJob($job)) {
            return back()->with('status', 'This job already bookmarked!');
        }
        $this->user->bookmarks()->attach($job->id);
        return back()->with('success', 'This job is bookmarked!');
    }

    public function destroy(Request $request, Job $job): RedirectResponse
    {


        if (!$this->user->isBookmarkedJob($job)) {
            return back()->with('error', 'This job not bookmarked!');
        }

        $this->user->bookmarks()->detach($job->id);
        return back()->with('success', 'This job is delete from bookmarks!');
    }
}
