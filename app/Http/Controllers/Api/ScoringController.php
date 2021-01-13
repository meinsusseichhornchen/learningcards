<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScoringCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ScoringController extends Controller
{

    public function index(Request $request) {
        $scores = $request->user()->scores()->paginate(1);

        return new ScoringCollection($scores);
    }

}
