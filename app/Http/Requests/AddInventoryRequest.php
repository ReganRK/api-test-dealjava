<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddInventoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['max:50', 'required'],
            'price' => ['integer', 'required'],
            'amount' => ['integer'],
            'unit' => ['max:5'],
        ];
    }

    protected function failedValidation(Validator $validation){
        throw new HttpResponseException(response([
            "errors" => $validation->getMessageBag(),
        ], 400));
    }
}
