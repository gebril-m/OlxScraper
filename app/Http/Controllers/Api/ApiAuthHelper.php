<?php
/**
 * Created by PhpStorm.
 * User: mallahsoft
 * Date: 21/10/18
 * Time: 11:01 ص
 */
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

trait ApiAuthHelper
{


    function doLogin($user)
    {
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::fromUser($user)) {
            return false;
        }
        return $jwt_token;
    }

    function getAuthUser()
    {
        $user = Auth::user();
        return $user;
    }

}