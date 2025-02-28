<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function superAdminDashboard()
    {
        return view('super-admin.dashboard');
    }
    public function usersList()
    {
        $users = User::with('role', 'profile')->get(); // Load users with roles & profile info
        return view('super-admin.users.all-users', compact('users'));
    }
    public function viewUser($id)
    {
        $user = User::with('role', 'profile', 'agency', 'contacts')->findOrFail($id);
        return view('super-admin.users.view', compact('user'));
    }

}
