<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function show_contact()
    {
        return view('frontend.contact');
    }
    public function store_contact(Request $request)
    {
        if (Auth::check()) {
            $name    = Auth::user()->name;
            $email   = Auth::user()->email;
            $this->validate($request, [
                'title' => ['required', 'string', 'min:10'],
                'message' => ['required', 'string', 'min:5']
                ]);
        } else {
            $name    = $request->name;
            $email   = $request->email;
            $this->validate($request, [
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'title' => ['required', 'string', 'min:10'],
                'message' => ['required', 'string', 'min:5']
            ]);
        }

        Contact::create([
            'name' => $name,
            'email' => $email,
            'title' => $request->title,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', 'Contact Has Been Add');
    }
}
