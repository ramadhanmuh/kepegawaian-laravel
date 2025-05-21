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
            'total' => $total
        ]);
    }

    function totalNonActiveEmployee() {
        $total = DB::table('terminations')
                    ->count();

        return response()->json([
            'total' => $total
        ]);
    }

    function totalMaleEmployee() {
        $total = DB::table('employees')
                    ->where('gender', '=', 'pria')
                    ->count();

        return response()->json([
            'total' => $total
        ]);
    }

    function totalFemaleEmployee() {
        $total = DB::table('employees')
                    ->where('gender', '=', 'wanita')
                    ->count();

        return response()->json([
            'total' => $total
        ]);
    }

    function totalEmployeeEducation() {
        $levels = ['sd', 'smp', 'sma', 's1', 's2', 's3'];

        $levelOrder = array_flip($levels);

        $data = DB::table('employee_education')
                ->select('employee_id', 'level')
                ->get()
                ->groupBy('employee_id')
                ->map(function ($group) use ($levelOrder) {
                    return collect($group)
                        ->sortByDesc(fn($item) => $levelOrder[$item->level])
                        ->first()
                        ->level;
                })
                ->values()
                ->countBy()
                ->toArray();

        // Pastikan level yang tidak muncul tetap nol
        $result = [];

        foreach ($levels as $level) {
            $result[$level] = $data[$level] ?? 0;
        }

        return response()->json($result);
    }
}