<?php

namespace App\Http\Controllers;

use App\Models\Trap;

class LandingController extends Controller
{
    public function index()
    {
        $totalTraps = Trap::count();
        $totalJenis = Trap::distinct('type_detector')->count('type_detector');

        return view('landing', compact('totalTraps', 'totalJenis'));
    }
}