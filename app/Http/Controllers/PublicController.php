<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page with diabetes awareness content
     */
    public function home()
    {
        return view('public.home');
    }

    /**
     * Display the diabetes details page with educational content
     */
    public function diabetesDetails()
    {
        return view('public.diabetes-details');
    }

    /**
     * Display the diabetes.html page (converted from static HTML)
     */
    public function diabetesHtml()
    {
        return view('public.diabetes-html');
    }

    /**
     * Display the home page (index.html converted from static HTML)
     */
    public function indexHtml()
    {
        return view('public.index-html');
    }
}
