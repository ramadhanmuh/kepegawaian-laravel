<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function view() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                            ->first();

        return view('pages.auth.login', $data);
    }

    function authenticate(AuthenticateRequest $request) {
        dd('test');
        $credentials = $request->only('email', 'password');

        $remember = empty($request->remember_me) ? false : true;
 
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
 
            return redirect()->route('dashboard.index');
        }
 
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak sesuai dengan catatan kami.',
        ]);
    }
}
