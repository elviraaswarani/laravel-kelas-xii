<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $filmCount = Film::count();
        $userCount = User::count();
        $reviewCount = Kritik::count();
        $recentFilms = Film::query()->with('genre')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('filmCount', 'userCount', 'reviewCount', 'recentFilms'));
    }
}