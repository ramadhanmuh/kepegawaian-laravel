<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function view() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        return view('pages.auth.login', $data);
    }

    function authenticate(AuthenticateRequest $request): RedirectResponse {
        $credentials = $request->only('email', 'password');

        $remember = empty($request->remember_me) ? false : true;
 
        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Kredensial yang diberikan tidak sesuai dengan catatan kami.',
            ]);
        }

        $request->session()->regenerate();

        if (Auth::user()->role === 'super_admin') {
            return redirect()->route('super-admin.dashboard.index');
        }
 
        return redirect()->route('admin.dashboard.index');
    }

    function logout(Request $request): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
    
        return redirect()->route('login.view');
    }
}
