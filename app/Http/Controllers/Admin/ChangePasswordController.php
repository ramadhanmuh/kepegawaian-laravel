<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    function edit() : View
    {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        return view('pages.admin.change-password', $data);
    }

    function update(ChangePasswordRequest $request) : RedirectResponse
    {
        User::where('id', Auth::user()->id)
            ->limit(1)
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        return redirect()->route('admin.change-password.edit')
                        ->with('success', 'Berhasil mengubah kata sandi.');
    }
}
