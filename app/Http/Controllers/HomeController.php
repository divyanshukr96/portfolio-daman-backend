<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Contracts\Support\Renderable;

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
     * @return Renderable
     */
    public function index()
    {
        return view('home', ['contacts' => Contact::paginate(10)]);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function gallery()
    {
        return view('gallery');
    }
}
