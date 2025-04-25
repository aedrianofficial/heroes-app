<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
    // Validate user input
    $request->validate([
        'login' => 'required|string', // Can be email or username
        'password' => 'required|string',
        'remember' => 'nullable|boolean', // Remember Me checkbox
    ]);

    // Determine if login is by email or username
    $credentials = filter_var($request->login, FILTER_VALIDATE_EMAIL)
        ? ['email' => $request->login, 'password' => $request->password]
        : ['username' => $request->login, 'password' => $request->password];

    // Attempt login with "remember" functionality
    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();

        // Check if email is verified
        if (is_null($user->email_verified_at)) {
            event(new Registered($user));
            return redirect()->route('verification.notice');
        }

        $request->session()->regenerate();

        // Redirect based on role and agency
        $role = $user->role->name ?? null;
        $agency = $user->agency->name ?? null;

        if ($role === 'admin') {
            switch ($agency) {
                case 'PNP':
                    return redirect()->route('admin.pnp')->with('success', 'Login successful!');
                case 'BFP':
                    return redirect()->route('admin.bfp')->with('success', 'Login successful!');
                case 'MDRRMO':
                    return redirect()->route('admin.mdrrmo')->with('success', 'Login successful!');
                case 'MHO':
                    return redirect()->route('admin.mho')->with('success', 'Login successful!');
                case 'COAST GUARD':
                    return redirect()->route('admin.coastguard')->with('success', 'Login successful!');
                case 'LGU':
                    return redirect()->route('admin.lgu')->with('success', 'Login successful!');
                default:
                    return redirect()->route('welcome')->with('success', 'Login successful!');
            }
        } elseif ($role === 'super admin') {
            return redirect()->route('superadmin.dashboard')->with('success', 'Login successful!');
        } elseif ($role === 'user') {
            return redirect()->route('welcome')->with('success', 'Login successful!');
        }

        // If none match, logout
        Auth::logout();
        return back()->withErrors(['login' => 'Access denied. No dashboard found for your role and agency.']);
    }

    return back()->withErrors(['login' => 'Invalid login credentials.']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
