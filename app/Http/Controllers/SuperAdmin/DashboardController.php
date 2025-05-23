<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Carbon\Carbon;
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

    function totalEmployeeAge() {
        $employees = DB::table('employees')->select('date_of_birth')->get();

        $groups = [
            '20 tahun ke bawah' => 0,
            'Usia 20an' => 0,
            'Usia 30an' => 0,
            'Usia 40an' => 0,
            'Usia 50an' => 0,
            'Usia 60 tahun ke atas' => 0,
        ];

        foreach ($employees as $emp) {
            $age = Carbon::parse($emp->date_of_birth)->age;

            if ($age <= 20) {
                $groups['20 tahun ke bawah']++;
            } elseif ($age >= 21 && $age <= 29) {
                $groups['Usia 20an']++;
            } elseif ($age >= 30 && $age <= 39) {
                $groups['Usia 30an']++;
            } elseif ($age >= 40 && $age <= 49) {
                $groups['Usia 40an']++;
            } elseif ($age >= 50 && $age <= 59) {
                $groups['Usia 50an']++;
            } else {
                $groups['Usia 60 tahun ke atas']++;
            }
        }

        return response()->json($groups);
    }
}