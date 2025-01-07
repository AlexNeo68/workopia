<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $title = 'Available jobs';
        $jobs = ['Software engineer', 'Coder', 'Hacker'];
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
    public function store(Request $request): JsonResponse
    {
        $title = $request->input('title');
        $description = $request->input('description');

        return response()->json([
            'title' => $title,
            'description' => $description,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $title = $id;
        return view('jobs.show', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): string
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): string
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): string
    {
        return 'destroy';
    }
}
