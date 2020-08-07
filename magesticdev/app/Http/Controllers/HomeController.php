<?php

namespace App\Http\Controllers;

use App\Profesor;
use Carbon\Carbon;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesors = Profesor::whereDay('fecha_nacimiento','=',Carbon::now()->format('d'))
                ->whereMonth('fecha_nacimiento','=',Carbon::now()->format('m'))->get();
        return view('pages.admin')->with('profesors',$profesors);
    }
}
