<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (HomePages) NutriGrow.
     */
    public function index()
    {
        if (view()->exists('HomePages.index')) {
            return view('HomePages.index');
        }

        return view('index');
    }
}
