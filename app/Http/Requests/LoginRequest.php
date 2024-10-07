<?php

 namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_username' => 'required',
            'user_password' => 'required',
        ];
    }

    public function authorize()
    {
        return true; // Izinkan semua user
    }
}
