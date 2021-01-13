<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionCollection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // Auth
    public function __construct() {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Request $request) {
        $collections = $request->user()->collections;

        return new CollectionCollection($collections);
    }
}
