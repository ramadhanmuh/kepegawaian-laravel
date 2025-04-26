<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class HomeController extends Controller
{
    function index() : View {
        $data['application'] = Application::select([
            'name', 'description', 'copyright', 'favicon'
        ])->first();

        return view('pages.home', $data);
    }

    function acceptCookie(Request $request) : Response {
        // Berlaku 1 tahun
        return response('OK')->cookie('cookie_consent', true, 525600);
    }
}
