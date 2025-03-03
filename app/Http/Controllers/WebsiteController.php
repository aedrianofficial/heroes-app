<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function news(){
        return view('website.news');
    }
    public function safetyGuide(){
        return view('website.safetyguide');
    }
    public function aboutUs(){
        return view('website.about_us');
    }
    public function contact(){
        return view('website.contact');
    }
}
