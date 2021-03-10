<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Ipv4Network;
use App\Models\Rack;
use Illuminate\Http\Request;

class HomeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hardware_count   = Hardware::count();
        $rack_count       = Rack::count();
        $rack_units_count = Rack::sum('height');
        $ipv4_network_count = Ipv4Network::count();

        return view('dashboard', compact('hardware_count', 'rack_count', 'rack_units_count', 'ipv4_network_count'));
    }
}
