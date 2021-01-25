<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    use ResponseMessages;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return $this-> msgError($validator->errors(), 401);
        }
        $credentials = $request->only(['username', 'password']);
        $token = auth('api')->attempt($credentials);
        if(!$token){
            return $this->msgError('UserName Or Password InValid', 401);
        }
       return $this->returnDate('token', $token, 'Login successfully');
    }
    public function refresh()
    {
        $refresh_token = auth('api')->refresh();
        return $this->returnDate('refresh_token', $refresh_token, 'success refresh token');
    }
    public function logout()
    {
        auth('api')->logout();
        return $this->msgSuccess('Success LogOut');
    }
}
