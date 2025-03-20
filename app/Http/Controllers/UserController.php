<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserProfile;
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


}
