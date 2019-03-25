<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Checkpwd extends FormRequest
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
            'u_pwd'=>[
                'required',
                'confirmed'
            ],
            'u_pwd_confirmation'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'u_pwd.required'=>'密码必填',
            'u_pwd.regex'=>'请输入6-16位数字或字母组成的密码!',
            'u_pwd_confirmation.required'=>'确认密码必填',
            'u_pwd.confirmed'=>'2次密码不一致'
        ];
    }
}
