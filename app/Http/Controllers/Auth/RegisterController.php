<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', 'string', 'min:8'],
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'extname' => 'nullable|string|max:50',
            'bday' => 'required|date',
            'contact_number' => 'required|string|max:11',
        ]);
    
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'agency_id' => 1,
        ]);
    
        UserProfile::create([
            'user_id' => $user->id,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'extname' => $request->extname,
            'bday' => $request->bday,
        ]);
    
        UserContact::create([
            'user_id' => $user->id,
            'contact_number' => $request->contact_number,
        ]);
    
        // Log in and send verification email
        Auth::login($user);
        event(new Registered($user));
    
        return redirect()->route('verification.notice')->with('status', 'verification-link-sent');
    }
}
