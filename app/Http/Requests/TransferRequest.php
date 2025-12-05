<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_user_id' => ['required', 'integer', 'min:1'],
            'to_user_id' => ['required', 'integer', 'min:1', 'different:from_user_id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'comment' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
