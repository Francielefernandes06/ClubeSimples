<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Carbon\Carbon;



class HomeController extends Controller
{
    public function index()
    {
        $eventosDestaque = Evento::ativos()
        ->futuros()
        ->orderBy('data')
        ->take(3)
        ->get();

        return view('welcome', compact('eventosDestaque'));
    }
}
