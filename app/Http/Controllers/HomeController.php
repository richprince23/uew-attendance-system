<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        // if (auth()->user()->role == 'admin') {
        //     return view('admin.dashboard');
        // } else if (auth()->user()->role == 'lecturer') {
        //     return view('app.Filament.Lecturer.Pages.Dashboard');
        // } else {
        //     return view('student.dashboard');
        // }

        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard');
        } else if (auth()->user()->hasRole('lecturer')) {
            return view('lecturer.dashboard');
        } else {
            return view('student.dashboard');
        }
    }
}
