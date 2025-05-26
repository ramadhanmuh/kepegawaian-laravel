<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    function index() : View
    {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        $data['item'] = User::select([
            'name', 'email', 'phone', 'role', 'created_at', 'updated_at'
        ])->find(Auth::user()->id);

        return view('pages.admin.profile.index', $data);
    }

    function edit() : View
    {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                        ->first();

        $data['item'] = User::select([
            'name', 'email', 'phone'
        ])->find(Auth::user()->id);

        return view('pages.admin.profile.edit', $data);
    }

    function update(UpdateProfileRequest $request) : RedirectResponse
    {
        User::where('id', Auth::user()->id)
            ->limit(1)
            ->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('admin.profile.index')
                        ->with('success', 'Berhasil mengubah profil.');
    }
}
