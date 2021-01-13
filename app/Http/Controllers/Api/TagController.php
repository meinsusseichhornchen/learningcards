<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagController extends Controller
{

    public function index(Request $request) {
        return Tag::all(['id', 'name', 'created_at'])->sortBy('created_at');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' =>  [
                'required',
                Rule::unique('tags')->where(function($query) use($data) {
                   return $query->where('name', $data['name'])
                                ->where('author', auth()->user()->id);
                })
            ],
        ]);
    }

    public function store(Request $request) {
        $this->validator($request->all())->validate();

        if ($request->ajax()) {

            request()->user()->tags()->create([
                'name' => $request->name
            ]);

            return Tag::all(['id', 'name', 'created_at'])->sortBy('created_at');
        }

        // TODO
        return 'hola';
    }

}
