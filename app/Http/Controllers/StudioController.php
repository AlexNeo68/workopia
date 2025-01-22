<?php

namespace App\Http\Controllers;


use App\Models\Studio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudioController extends Controller
{

    use AuthorizesRequests;

    // @desc    Show all studio listings
    // @route   GET /studios
    public function index(): View
    {

        $title = 'Студии ПравИло';
        $studios = Studio::orderByDesc('sort')->paginate(9);
        return view('studios.index', compact('title', 'studios'));
    }

    // @desc    Show create studio form
    // @route   GET /studios/create
    public function create(): View
    {
        $title = 'Создать студию';
        return view('studios.create', compact('title'));
    }

    // @desc    Save studio to database
    // @route   POST /studios
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'preview_text' => 'required|string',
            'detail_text' => 'required|string',
            'cost_training' => 'required|integer',
            'tags' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'coordinates' => 'required|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'gallery' => 'nullable',
            'website_link' => 'nullable|url',
            'vk_link' => 'nullable|url',
        ]);


        $validatedData['user_id'] = auth()->id();

        $studio = Studio::create($validatedData);

        if ($request->hasFile('logo')) {
            $studio->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('studios.show', $studio)->with('success', 'Студия успешно создана!');
    }

    // @desc    Display a single studio listing
    // @route   GET /studios/{$id}
    public function show(Studio $studio): View
    {
        return view('studios.show', compact('studio'));
    }

    // @desc    Show edit studio form
    // @route   GET /studios/{$id}/edit
    public function edit(Studio $studio): View
    {
        $this->authorize('update', $studio);
        return view('studios.edit', compact('studio'));
    }

    // @desc    Update studio listing
    // @route   PUT /studios/{$id}
    public function update(Request $request, Studio $studio): RedirectResponse
    {
        $this->authorize('update', $studio);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'preview_text' => 'required|string',
            'detail_text' => 'required|string',
            'cost_training' => 'required|integer',
            'tags' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'coordinates' => 'required|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'gallery' => 'nullable',
            'website_link' => 'nullable|url',
            'vk_link' => 'nullable|url',
        ]);

        $studio->update($validatedData);

        if ($request->hasFile('logo')) {
            $studio->clearMediaCollection('logo');
            $studio->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('studios.show', $studio->id)->with('success', 'Студия успешно обновлена!');
    }

    // @desc    Delete a studio listing
    // @route   DELETE /studios/{$id}
    public function destroy(Studio $studio): string
    {
        $this->authorize('update', $studio);
        $studio->clearMediaCollection('logo');
        $studio->delete();

        $route = 'studios.index';

        if (request()->query('from') == 'dashboard') {
            $route = 'dashboard.index';
        }

        return redirect()->route($route)->with('success', 'Студия успешно удалена!');
    }

    public function search(Request $request): View
    {
        /*
            Создание базы данных в postgresql для русского контента
            CREATE DATABASE your_database_name
                WITH ENCODING='UTF8'
                    LC_COLLATE='ru_RU.UTF-8'
                    LC_CTYPE='ru_RU.UTF-8'
                    TEMPLATE=template0;


            */


        $studios = Studio::query();

        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));



        if ($keywords) {
            $studios = $studios->where(function ($q) use ($keywords) {
                $q->whereRaw('LOWER(title) ilike ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(preview_text) ilike ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(detail_text) ilike ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(tags) ilike ?', ['%' . $keywords . '%']);
            });
        }

        if ($location) {
            dump($location);
            $studios = $studios->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(address) ilike ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(city) ilike ?', ['%' . $location . '%']);
            });
        }
        $studios = $studios->paginate(12);

        return view('studios.index', compact('studios'));
    }
}
