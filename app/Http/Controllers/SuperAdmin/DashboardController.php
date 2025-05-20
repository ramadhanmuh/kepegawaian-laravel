<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index() {
        $data['application'] = Application::select(['name', 'copyright', 'favicon'])
                                            ->first();

        return view('pages.super-admin.dashboard', $data);
    }
    
    function totalActiveEmployee() {
        $total = DB::table('employees')
                    ->whereNotIn('id', function ($query) {
                        $query->select('employee_id')
                            ->from('terminations');
                    })
                    ->count();

        return response()->json([
            // 'total' => $total
            'total' => 1000
        ]);
    }
}