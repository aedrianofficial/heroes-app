<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserProfile;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }
    public function edit($id)
    {
        $user = User::with(['profile', 'role', 'agency', 'contacts'])->findOrFail($id);
        $roles = Role::all();
        $agencies = Agency::all();

        return view('super-admin.users.edit', compact('user', 'roles', 'agencies'));
    }
    public function verifyNotice(){
        return view('auth.verify-email');
    }
    public function verifyHandler(Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }
    
    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect()->route('welcome')->with('verified', 'Email verified successfully.');
    }
}
