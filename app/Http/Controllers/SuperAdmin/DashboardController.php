<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                            ->first();

        return view('pages.super-admin.dashboard', $data);
    }
}
