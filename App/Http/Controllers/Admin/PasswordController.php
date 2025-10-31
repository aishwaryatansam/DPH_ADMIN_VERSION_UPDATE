<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Auth;
use Validator;

class PasswordController extends Controller
{
    public function managePassword() {
    	return view('admin.password.change-password');
    }

    public function manageUserPassword($id) {
        if(!isAdmin())
        {
            return redirect('/');
        }
        return view('admin.password.change-password', compact('id'));
    }

    public function updatePassword(Request $request) {

    	$validator = $this->validate($request,[
    		'password' => 'required|confirmed|min:6|max:50'
    	]);

        $user_id = '';

        if($request->has('_identifier') && $user_id = $request->get('_identifier'))
        {
            $user_id = decryptData($user_id);

        } else {

            $user_id = Auth::user()->id;    
        }    	

      
    	$user = new User();
    	$userData = $user->find($user_id);

    	$userData->fill(['password'=> Hash::make($request->password)])->save();

    	updatedResponse('Password Updated Successfully !');

    	return redirect()->route('admin.dashboard');
    }
}
