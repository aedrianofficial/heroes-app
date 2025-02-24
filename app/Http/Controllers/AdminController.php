<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pnpDashboard()
    {
        return view('admin.pnp.dashboard');
    }

    public function bfpDashboard()
    {
        return view('admin.bfp.dashboard');
    }

    public function mdrrmoDashboard()
    {
        return view('admin.mdrrmo.dashboard');
    }

    public function mhoDashboard()
    {
        return view('admin.mho.dashboard');
    }

    public function coastGuardDashboard()
    {
        return view('admin.coast-guard.dashboard');
    }

    public function lguDashboard()
    {
        return view('admin.lgu.dashboard');
    }
}
