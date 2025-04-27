<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    function index(): View
    {
        $data['application'] = Application::select([
            'name', 'description', 'copyright', 'favicon',
            'created_at', 'updated_at'
        ])->first();

        return view('pages.super-admin.application.index', $data);
    }

    function edit(): View
    {
        $data['application'] = Application::select([
            'name', 'description', 'copyright', 'favicon',
            'created_at', 'updated_at'
        ])->first();

        return view('pages.super-admin.application.edit', $data);
    }

    function update(UpdateApplicationRequest $request): RedirectResponse
    {
        $application = Application::select(['id'])
                                    ->first();

        if ($request->hasFile('favicon')) {
            $destinationPath = public_path('assets/favicon');

            $fileName = 'favicon.ico';

            File::delete($destinationPath . '/' . $fileName);

            $request->file('favicon')->move($destinationPath, $fileName);
        }

        Application::where('id', $application->id)
                    ->limit(1)
                    ->update($request->only([
                        'name', 'description', 'copyright',
                    ]));

        return redirect()->route('super-admin.application.index')
                        ->with('success', 'Berhasil mengubah data aplikasi.');
    }
}
