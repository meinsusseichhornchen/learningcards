<?php

namespace App\Http\Requests;

use App\Card;
use Illuminate\Foundation\Http\FormRequest;

class StoreCard extends FormRequest
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
            'answer.*' => ['max:100'],
            'cardable_type' => function($attribute, $value, $fail) {
                if (!Card::existCardType($value)) {
                    $fail(trans('validation.cards.cardable_type.not_exist'));
                }
            }
        ];
    }
}
