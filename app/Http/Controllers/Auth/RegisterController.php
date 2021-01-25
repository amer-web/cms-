<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ResponseMessages;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['required', 'numeric', 'unique:users,mobile'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_image' => ['file', 'max:8000', 'mimes:png,jpg,jpeg'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if(isset($data['user_image']) && $data['user_image'] != null)
        {
            $image = $data['user_image'];
            $filename =  'assest/users/' . Str::slug($data['username']) .'.'. $image->getClientOriginalExtension();
            $path = public_path($filename);
            image::make($image->getRealPath())->resize(80, null, function($constraint){
                $constraint->aspectRatio();
            })->crop(80,80,0,0)->save($path, 100);
            $user->update(['user_image' => $filename ]);
        }
        $user->attachRole('user');
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        if($request->wantsJson()){
            $token  = auth('api')->tokenById($user->id);
            return $this->returnDate('token', $token, 'You Register Check Your Email');
        }
    }
}
