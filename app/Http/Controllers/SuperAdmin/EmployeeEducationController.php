<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeEducationRequest;
use App\Models\Application;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use Illuminate\Http\Request;

class EmployeeEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.employee-education.index', $data);
    }

    function list(Request $request)
    {
        $columns = [
            0 => 'employee_education.id',
            1 => 'employees.full_name',
            2 => 'employee_education.level',
            3 => 'employee_education.school_name',
            4 => 'employee_education.major',
        ];

        $length = $request->input('length');

        $length = is_numeric($length) || $length > 100 
                    ? 10
                    : $length;

        $column = $request->input('order.0.column');

        $column = array_key_exists($column, $columns)
                    ? $column
                    : 1;

        $dir = $request->input('order.0.dir');

        $dir = $dir === 'asc' || $dir === 'ASC' || $dir === 'desc' || $dir === 'DESC'
                ? $dir
                : 'asc';

        $searchValue = $request->input('search.value');

        $level = $request->level;

        $query = EmployeeEducation::query();

        $query = $query->select([
            'employee_education.id', 'employee_education.level',
            'employee_education.school_name', 'employees.full_name',
            'employees.number', 'employee_education.major'
        ])->join('employees', 'employee_education.employee_id', '=', 'employees.id');

        if (is_string($level) && !empty($level)) {
            $query->where('employee_education.level', $level);
        }

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('employees.full_name', 'like', "%{$searchValue}%")
                                    ->orWhere('employees.number', 'like', "%{$searchValue}%")
                                    ->orWhere('employee_education.school_name', 'like', "%{$searchValue}%")
                                    ->orWhere('employee_education.level', 'like', "%{$searchValue}%")
                                    ->orWhere('employee_education.major', 'like', "%{$searchValue}%");
                                });
                            });
        }

        $totalFiltered = $query->count();

        $users = $query->orderBy($columns[$column], $dir)
                       ->offset($request->input('start'))
                       ->limit($length)
                       ->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => EmployeeEducation::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        $data['selectedEmployee'] = null;

        if (old('employee_id') !== null) {
            $data['selectedEmployee'] = Employee::select([
                'id', 'full_name', 'number'
            ])->where('id', '=', old('employee_id'))
            ->first();
        }
        
        return view('pages.super-admin.employee-education.create', $data);
    }

    function employees(Request $request)
    {
        $search = $request->q;

        $data = Employee::query();

        if ($search !== null) {
            $data = $data->where('full_name', 'like', '%' . $search . '%')
                        ->orWhere('number', 'like', '%' . $search . '%');
        }
            
        $data = $data->select(['id', 'full_name', 'number'])
                    ->limit(10)
                    ->orderBy('full_name', 'asc')
                    ->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeEducationRequest $request)
    {
        EmployeeEducation::create($request->validated());

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data pendidikan pegawai.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['item'] = EmployeeEducation::select([
            'employee_education.id',
            'employee_education.employee_id',
            'employee_education.level',
            'employee_education.school_name',
            'employee_education.school_address',
            'employee_education.major',
            'employee_education.created_at',
            'employee_education.updated_at',
            'employees.full_name',
            'employees.number',
            'employees.photo'
        ])->join('employees', 'employee_education.employee_id', '=', 'employees.id')
        ->where('employee_education.id', '=', $id)
        ->first();

        if ($data['item'] === null) {
            abort(404);
        }

        switch ($data['item']->level) {
            case 'sd':
                $data['item']->level = 'SD';
                break;
            case 'smp':
                $data['item']->level = 'SMP';
                break;
            case 'sma':
                $data['item']->level = 'SMA';
                break;
            case 's1':
                $data['item']->level = 'Sarjana (S1)';
                break;
            case 's2':
                $data['item']->level = 'Magister (S2)';
                break;
            case 's3':
                $data['item']->level = 'Doktor (S3)';
                break;
            default:
                $data['item']->level = '-';
                break;
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.employee-education.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['item'] = EmployeeEducation::select([
            'employee_education.id',
            'employee_education.employee_id',
            'employee_education.level',
            'employee_education.school_name',
            'employee_education.school_address',
            'employee_education.major',
            'employee_education.created_at',
            'employee_education.updated_at',
            'employees.full_name',
            'employees.number',
        ])->join('employees', 'employee_education.employee_id', '=', 'employees.id')
        ->where('employee_education.id', '=', $id)
        ->first();

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        if (old('employee_id') !== null) {
            $data['selectedEmployee'] = Employee::select([
                'id', 'full_name', 'number'
            ])->where('id', '=', old('employee_id'))
            ->first();
        } else {
            $data['selectedEmployee'] = Employee::select([
                'id', 'full_name', 'number'
            ])->where('id', '=', $data['item']->employee_id)
            ->first();
        }
        
        return view('pages.super-admin.employee-education.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
