<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

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

    use RegistersUsers;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type_id' => array_flip(config('constant.user_type'))[1] ?? 0,
        ]);
    }

    public function registerUser(Request $request) {

        $rules = [
            'name' => 'required|min:2|max:100',
            'contact_number' => 'required|exists:verify_otps,mobile',
            'otp' => 'required',
            'email' => 'sometimes|nullable|email|unique:users,email',
            'address_line_1' => 'required|min:2|max:100',
            'address_line_2' => 'sometimes|nullable|min:2|max:100',
            'city' => 'required|min:2|max:50',
            'pincode' => 'required|min:5|max:8'
        ];
        $this->validate($request,$rules);

        $userData = [
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'otp' => $request->otp,
            'email' => $request->email,
            'user_type_id' => array_flip(config('constant.user_type'))[2] ?? 2,
            'country_code' => '+91',
            'status'=> _active(),
        ];

        $user = User::create($userData);

        $userAddressData = [
            'user_id' => $user->id,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'state_id' => 1,
            'country_id' => 1,
            'is_current' => _active(),
            'created_by'=> $user->id,
            'status' => _active(),
        ];

        UserAddress::create($userAddressData);

        Auth::loginUsingId($user->id);

        createdResponse("Registered Successfully !");

        return response(['message' => 'User Registered Successfully !']);
    }

}
