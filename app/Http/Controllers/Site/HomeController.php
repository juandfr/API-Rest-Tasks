<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use SEO;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        SEO::setTitle('Meu titulo');
        SEO::setDescription('Minha descrição');

        return view('site::home.index');
    }
}
