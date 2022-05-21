<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckOutRequest extends FormRequest
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
            'user_id' => 'required',
            'product_code'  => 'required|nullable|string',
            'qty' => 'required',
            'price' => 'required',
        ];
    }

   

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'    => 'failed',
            'messages'  => $validator->errors()->all()
        ], 422));
    }
}
