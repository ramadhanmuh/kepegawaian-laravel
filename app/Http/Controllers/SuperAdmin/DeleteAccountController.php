<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DeleteAccountController extends Controller
{
    function destroy() : RedirectResponse {
        $superAdmin = User::where('role', 'super_admin')
                            ->count();

        if ($superAdmin < 2) {
            return redirect()->back()
                            ->with('alertError', 'Gagal menghapus akun. Akun Super Admin harus minimal 1.');
        }

        User::where('id', Auth::user()->id)
            ->limit(1)
            ->delete();

        return redirect()->route('login.view')
                        ->with('success', 'Berhasil menghapus akun.');
    }
}
