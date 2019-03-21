<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Captcha;
class VerifierController extends Controller
{
    public function verifier()
    {
        $code=new Captcha();
        session(['code'=>$code->getCode()]);
        $code->doimg();
    }
}
