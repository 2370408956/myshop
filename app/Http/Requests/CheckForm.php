<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckForm extends FormRequest
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
            'u_name'=>[
                'required',
                'unique:shop_user',
                'regex:/^1[34578]\d{9}$/'
            ],
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
            'u_name.required' => '用户名必填',
            'u_name.regex'=>'手机号不规范',
            'u_name.unique'=>'已被注册',
            'u_pwd.required'=>'密码必填',
            'u_pwd.regex'=>'请输入6-16位数字或字母组成的密码!',
            'u_pwd_confirmation.required'=>'确认密码必填',
            'u_pwd.confirmed'=>'2次密码不一致'
        ];
    }
}
