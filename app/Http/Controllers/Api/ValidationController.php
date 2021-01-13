<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as v;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ValidationController extends Controller
{
    const TMP_FILES_FOLDER = 'tmp/files';

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function setRules(String $field_name, array $rules) {
        foreach ($rules as $rule) {
            $this->validator[$field_name][] = $rule;
        }
    }

    protected function validator(array $data, array $rules, $trans = []) {
        return $trans ? v::make($data, $rules, $trans)
                        : v::make($data, $rules);
    }

    public function validateFields(Request $request) {
        $validator = $this->validator($request->values, $request->rules);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        return $this->validated($request);
    }

    public function validateFile(Request $request) {
        $validator = $this->validator([$request[$request->name]], $request->rules);

        if ($validator->fails()) {
            return response([
                $request->name => $validator->errors()
            ], 422);
        }

        return $request[$request->name];
    }

/*    public function validateFiles(Request $request) {
        $validator = $this->validator($request[$request->name], $request->rules);

        if ($validator->fails()) {
            return response([
                $request->name => $validator->errors()
            ], 422);
        }

        return $this->validated($request);
    }*/

/*    protected function storeValidatedFile($files) {
        $storedFiles = [];

        foreach($files as $file) {
            $filePath = $file->store(self::TMP_FILES_FOLDER, 'public');

            $storedFiles[] = [
                'url' => asset('storage/' . $filePath),
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) .'.'. $file->getClientOriginalExtension(),
                'file' => $file,
            ];
        }

        return $storedFiles;
    }*/

    protected function validated(Request $request) {
        return $request->values;
    }
}
