<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollection extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:150'],
            'tags.*' => ['exists:tags,id'],
            'description' => ['max:350']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];

        foreach ($this->get('tags') as $key => $tag) {
            $messages["tags.$key.exists"] = trans('validation.custom.tags.not_exist');
        }

        return $messages;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {
        $validator->after(function($validator) {
            if (count($validator->errors()->get('tags.0')) > 0) {
               $validator->errors()->add('tags', trans('validation.custom.tags.not_exist'));
            }
        });
    }
}
