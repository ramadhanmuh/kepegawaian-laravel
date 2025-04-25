<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    function index() : View {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        $data['item'] = User::select([
            'name', 'email', 'phone', 'role', 'created_at', 'updated_at'
        ])->find(Auth::user()->id);

        return view('pages.super-admin.profile.index', $data);
    }

    function edit() : View {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        $data['item'] = User::select([
            'name', 'email', 'phone', 'role', 'created_at', 'updated_at'
        ])->find(Auth::user()->id);

        return view('pages.super-admin.profile.edit', $data);
    }
}
