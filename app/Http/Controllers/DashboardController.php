<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index(){
        return view(view:'backend.content.dashboard');
    }

    public function profil(){
        return view('backend.content.profil');
    }
}
