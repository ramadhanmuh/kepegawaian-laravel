<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                            ->first();

        return view('pages.dashboard.dashboard', $data);
    }
}
