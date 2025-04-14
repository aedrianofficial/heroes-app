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
        $remember = $request->has('remember_token');
    
        if (Auth::attempt($credentials, $remember)) {
            // Get authenticated user
            $user = Auth::user();
            
            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                // Trigger the Registered event to send verification email
                event(new Registered($user));
                
                return redirect()->route('verification.notice');
            }
            
            $request->session()->regenerate();
    
            // Define role-agency dashboard redirection
            $dashboardRoutes = [
                'user' => [
                    'DEFAULT' => '/',
                ],
                'admin' => [
                    'DEFAULT' => '/',
                    'PNP' => '/admin/pnp-dashboard',
                    'BFP' => '/admin/bfp-dashboard',
                    'MDRRMO' => '/admin/mdrrmo-dashboard',
                    'MHO' => '/admin/mho-dashboard',
                    'COAST GUARD' => '/admin/coast-guard-dashboard',
                    'LGU' => '/admin/lgu-dashboard',
                ],
                'super admin' => [
                    'DEFAULT' => '/super-admin/dashboard',
                ],
            ];
    
            // Check if the user has an assigned dashboard
            if (isset($dashboardRoutes[$user->role->name][$user->agency->name])) {
                return redirect()->intended($dashboardRoutes[$user->role->name][$user->agency->name])
                    ->with('success', 'Login successful!');
            }
    
            // Logout & deny access if no matching dashboard
            Auth::logout();
            return back()->withErrors(['login' => 'Access denied. Your role and agency do not match any dashboard.']);
        }
    
        return back()->withErrors(['login' => 'Invalid credentials.'])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
