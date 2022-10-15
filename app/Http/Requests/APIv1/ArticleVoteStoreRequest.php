<?php

namespace App\Http\Requests\APIv1;

use App\Http\Requests\ApiRequest;

class ArticleVoteStoreRequest extends ApiRequest
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
            'value' => 'integer|between:-1,1',
        ];
    }
}
