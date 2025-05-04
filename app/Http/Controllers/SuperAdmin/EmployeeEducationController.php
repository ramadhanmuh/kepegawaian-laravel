<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Employee;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.employee-education.create', $data);
    }

    function employees(Request $request)
    {
        $search = $request->q;

        $data = Employee::query()
            ->where('full_name', 'like', '%' . $search . '%')
            ->orWhere('number', 'like', '%' . $search . '%')
            ->select(['id', 'full_name', 'number']) // Format untuk select2
            ->limit(10)
            ->orderBy('full_name', 'asc')
            ->get();

        return response()->json($data);    
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
