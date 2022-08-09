<?php

namespace App\Http\Requests\User;

use App\Constants\ErrorCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ChangePasswordRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['_result' => '0', '_error' => $validator->errors()->first(), '_errorCode' => ErrorCodes::FORM_INPUT_INVALID], 200);

        throw new ValidationException($validator, $response);
    }

    public function rules()
    {
        return [
            'new_password' => 'required|confirmed|digits:4',
        ];
    }

    public function messages()
    {
        return [
            'new_password.required' => __('user.new_password_required'),
            'new_password.numeric' => __('user.new_password_numeric'),
            'new_password.digits' => __('user.new_password_digits'),
            'new_password.confirmed' => __('user.new_password_confirmed'),
        ];
    }
}
