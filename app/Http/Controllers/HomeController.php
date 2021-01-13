<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Resources\CollectionCollection;
use App\Http\Resources\ScoringCollection;
use App\Http\Resources\ScoringResource;
use App\User;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$scores = response()->json(new ScoringCollection(request()->user()->scores()->paginate(1)));


        return view('home');
    }
}
