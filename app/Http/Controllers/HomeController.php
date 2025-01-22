<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    // @desc Show home index view
    // @route GET /
    public function index(): View
    {

        $studios = Studio::latest()->limit(6)->get();
        return view('pages.home', compact('studios'));
    }
}
