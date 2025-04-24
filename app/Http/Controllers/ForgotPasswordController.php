<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    function index() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        return view('pages.auth.forgot-password', $data);
    }

    function reset(ForgotPasswordRequest $request) {
        $email = $request->email;

        $user = User::select(['email'])
                    ->where('email', $email)
                    ->first();

        if ($user === null) {
            $request->session()->flash('error', 'Email tidak ditemukan di catatan kami.');

            return back();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->upsert(
            [
                [
                    'email' => $email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            ],
            [
                'email'
            ],
            [
                'token', 'created_at'
            ]
        );

        Mail::to($email)->send(new ResetPassword($email, $token));

        $request->session()->flash('success', 'Berhasil mengirim ke email anda.');

        return back();
    }
}
