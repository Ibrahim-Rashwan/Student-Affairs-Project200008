<?php

namespace App\Http\Controllers;

use App\Shared\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = [
            'user' => Auth::user(),
            'id' => Shared::getActiveUserTypedId()
        ];

        return view('home')->with($data);
    }
}
