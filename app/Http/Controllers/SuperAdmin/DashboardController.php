<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Carbon\Carbon;
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
        $age_group = [
            '20_ke_bawah' => 0,
            '20an' => 0,
            '30an' => 0,
            '40an' => 0,
            '50an' => 0,
            '60_dan_ke_atas' => 0,
        ];

        $today = Carbon::today()->toDateString();

        $data = DB::table('employees')
            ->selectRaw('
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, ?) <= 20 THEN "20_ke_bawah"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, ?) BETWEEN 21 AND 29 THEN "20an"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, ?) BETWEEN 30 AND 39 THEN "30an"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, ?) BETWEEN 40 AND 49 THEN "40an"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, ?) BETWEEN 50 AND 59 THEN "50an"
                    ELSE "60_dan_ke_atas"
                END AS age_group,
                COUNT(*) AS total
            ', [$today, $today, $today, $today, $today])
            ->groupBy('age_group')
            ->orderByRaw('
                FIELD(age_group, 
                    "20_ke_bawah", "20an", "30an", "40an", "50an", "60_dan_ke_atas"
                )
            ')
            ->get();

        if ($data !== null) {
            foreach ($data as $value) {
                $age_group[$value->age_group] = $value->total;
            }
        }

        return response()->json($age_group);
    }
}