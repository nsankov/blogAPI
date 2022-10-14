<?php

namespace App\Http\Requests\APIv1;

use App\Http\Requests\ApiRequest;

class CategoryStoreRequest extends ApiRequest
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
            'title' => ['required', 'string', 'unique:categories,title'],
            'description' => ['string'],

        ];
    }
}
