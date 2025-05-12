<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Termination;
use App\Models\TerminationType;
use Illuminate\Http\Request;

class TerminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        $data['termination_types'] = TerminationType::select([
            'id', 'name'
        ])->orderBy('name')
        ->get();
        
        return view('pages.super-admin.termination.index', $data);
    }

    function list(Request $request)
    {
        $columns = [
            'terminations.id', 'employees.full_name',
            'termination_types.name', 'terminations.subject',
            'terminations.termination_date'
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

        $termination_type_id = $request->get('termination_type_id');

        $query = Termination::query();

        $query = $query->select([
            'terminations.id', 'employees.full_name',
            'termination_types.name', 'terminations.subject',
            'terminations.termination_date', 'employees.number'
        ])->join('employees', 'terminations.employee_id', '=', 'employees.id')
        ->join('termination_types', 'terminations.termination_type_id', '=', 'termination_types.id');

        if (is_string($termination_type_id) && !empty($termination_type_id)) {
            $query->where('terminations.termination_type_id', $termination_type_id);
        }

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('employees.full_name', 'like', "%{$searchValue}%")
                                        ->orWhere('terminations.subject', 'like', "%{$searchValue}%")
                                        ->orWhere('employees.number', 'like', "%{$searchValue}%")
                                        ->orWhere('termination_types.name', 'like', "%{$searchValue}%");
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
            'recordsTotal' => Termination::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
