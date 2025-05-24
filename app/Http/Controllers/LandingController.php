<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('frontend.content.home');
    }
    public function articlePage()
    {
        //return view('landing.about');
    }

    public function detailPage($id)
    {
        //return view('landing.detail', ['id' => $id]);
    }

    public function allArticles()
    {
        //return view('landing.allArticles');
    }
}
