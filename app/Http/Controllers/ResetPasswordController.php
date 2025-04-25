<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    function index(Request $request) {
        $email = $request->get('email');
        $token = $request->get('token');

        $passwordResetToken = DB::table('password_reset_tokens')
                                ->select(['email'])
                                ->where('email', '=', $email)
                                ->where('token', '=', $token)
                                ->where('created_at', '>=', Carbon::now()->subHour())
                                ->first();

        if ($passwordResetToken === null) {
            abort(404);
        }

        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        return view('pages.auth.reset-password', $data);
    }

    function update(Request $request) {
        $email = $request->get('email');
        $token = $request->get('token');

        $passwordResetToken = DB::table('password_reset_tokens')
                                ->select(['email'])
                                ->where('email', '=', $email)
                                ->where('token', '=', $token)
                                ->where('created_at', '>=', Carbon::now()->subHour())
                                ->first();

        if ($passwordResetToken === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|confirmed',
        ], [], [
            'password' => 'Kata Sandi'
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $password = $request->post('password');

        User::where('email', $email)
            ->limit(1)
            ->update(['password' => Hash::make($password)]);

        DB::table('password_reset_tokens')
            ->where('email', '=', $email)
            ->limit(1)
            ->delete();

        return redirect()->route('login.view')
                        ->with('success', 'Berhasil mengubah kata sandi.');
    }
}
