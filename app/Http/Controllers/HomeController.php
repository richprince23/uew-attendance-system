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
        if (auth()->user()->role == 'admin') {
            return redirect()->to('/admin');
        } else if (auth()->user()->role == 'lecturer') {
            return view('app.Filament.Lecturer.Pages.Dashboard');
        } else {
            return redirect()->to('');
        }

        // if (auth()->user()->hasRole('admin')) {
        //     return view('');
        // } else if (auth()->user()->hasRole('lecturer')) {
        //     return view('lecturer.dashboard');
        // } else {
        //     return view('student.dashboard');
        // }
    }
}
