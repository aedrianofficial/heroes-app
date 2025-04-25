<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserProfile;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    
    
    public function verifyEmail(EmailVerificationRequest $request)
    {
    $request->fulfill();

    // Manually log the user in
    Auth::login($request->user());

    $user = Auth::user();
    $role = $user->role->name ?? null;
    $agency = $user->agency->name ?? null;

    if ($role === 'admin') {
        switch ($agency) {
            case 'PNP':
                return redirect()->route('admin.pnp')->with('verified', 'Email verified successfully.');
            case 'BFP':
                return redirect()->route('admin.bfp')->with('verified', 'Email verified successfully.');
            case 'MDRRMO':
                return redirect()->route('admin.mdrrmo')->with('verified', 'Email verified successfully.');
            case 'MHO':
                return redirect()->route('admin.mho')->with('verified', 'Email verified successfully.');
            case 'COAST GUARD':
                return redirect()->route('admin.coastguard')->with('verified', 'Email verified successfully.');
            case 'LGU':
                return redirect()->route('admin.lgu')->with('verified', 'Email verified successfully.');
            default:
                return redirect()->route('welcome')->with('verified', 'Email verified successfully.');
        }
    } elseif ($role === 'super admin') {
        return redirect()->route('superadmin.dashboard')->with('verified', 'Email verified successfully.');
    } elseif ($role === 'user') {
        return redirect()->route('welcome')->with('verified', 'Email verified successfully.');
    }

    return redirect()->route('welcome')->with('verified', 'Email verified successfully.');
    }
}
