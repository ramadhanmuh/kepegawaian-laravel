<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Application;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        $data['designations'] = Designation::select([
            'id', 'name'
        ])->get();
        
        return view('pages.super-admin.employee.index', $data);
    }

    function list(Request $request)
    {
        $columns = [
            0 => 'employees.id',
            1 => 'employees.photo',
            2 => 'employees.full_name',
            3 => 'employees.number',
            4 => 'designations.name',
            5 => 'employees.phone',
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

        $designation_id = $request->designation_id;

        $query = Employee::query();

        $query = $query->select([
            'employees.id', 'employees.photo',
            'employees.full_name', 'employees.number',
            'designations.name as designation',
            'employees.phone'
        ])->leftJoin('designations', 'employees.designation_id', '=', 'designations.id');

        if (is_string($designation_id) && !empty($designation_id)) {
            $query->where('designations.id', $designation_id);
        }

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('employees.full_name', 'like', "%{$searchValue}%")
                                    ->orWhere('employees.number', 'like', "%{$searchValue}%")
                                    ->orWhere('employees.phone', 'like', "%{$searchValue}%");
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
            'recordsTotal' => Employee::count(),
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

        $data['designations'] = Designation::select([
            'id', 'name'
        ])->get();
        
        return view('pages.super-admin.employee.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $input = $request->validated();

        $photoFileDestinationPath = 'uploads/employee/photo';

        $photoFileDestinationFullPath = public_path($photoFileDestinationPath);

        $photoFile = $request->file('photo');

        $photoFileName = Str::random(40)
                        . '.'
                        . $photoFile->getClientOriginalExtension(); 

        $photoFile->move($photoFileDestinationFullPath, $photoFileName);

        $input['photo'] = $photoFileDestinationPath . '/' . $photoFileName;

        Employee::create($input);

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data pegawai.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
