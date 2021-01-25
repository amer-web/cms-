<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('frontend.users.change-password');
    }
    public function update(Request $request)
    {
        $this->validate($request, [
           'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);
        if(Hash::check($request->old_password, auth()->user()->password)){
            auth()->user()->update([
               'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('dashboard.index')->with('success', 'password successfully updated');
        }
        return redirect()->back()->with('error', 'confirm your password');
    }
}
