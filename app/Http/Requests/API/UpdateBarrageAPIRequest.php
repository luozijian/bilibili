<?php

namespace App\Http\Requests\API;

use App\Models\Barrage;
use InfyOm\Generator\Request\APIRequest;

class UpdateBarrageAPIRequest extends APIRequest
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
        return Barrage::$rules;
    }
}
