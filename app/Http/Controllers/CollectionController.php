<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests\StoreCollection;
use App\Http\Resources\CollectionCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    public function edit(Collection $collection) {
        $collection = new CollectionCollection([$collection]);

        return view('collections/edit', [
            'collection' => $collection->first()
        ]);
    }

    public function update(Collection $collection, StoreCollection $request) {
        $collection->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $collection->tags()
            ->sync($request->tags);

        $collection->save();

        return redirect()->route('home');
    }

    public function create() {
        return view('collections/create');
    }

    public function show(Collection $collection) {
        return view('collections/show', [
            'collection' => $collection
        ]);
    }

    public function store(StoreCollection $request) {
        $collection = auth()->user()->collections()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $collection->tags()
            ->sync($request->tags);

        $collection->players()
            ->sync([auth()->user()->id]);

        return redirect()->route('home');
    }
}
