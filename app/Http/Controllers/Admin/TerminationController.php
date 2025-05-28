<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTerminationRequest;
use App\Models\Application;
use App\Models\Employee;
use App\Models\Termination;
use App\Models\TerminationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        
        return view('pages.admin.termination.index', $data);
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
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        $data['termination_types'] = TerminationType::select([
            'id', 'name'
        ])->orderBy('name')
        ->get();

        $data['selectedEmployee'] = null;

        if (old('employee_id') !== null) {
            $data['selectedEmployee'] = Employee::select([
                'id', 'full_name', 'number'
            ])->where('id', '=', old('employee_id'))
            ->first();
        }
        
        return view('pages.admin.termination.create', $data);
    }

    function employees(Request $request)
    {
        $search = $request->q;

        $data = Employee::whereDoesntHave('termination');

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
    public function store(StoreTerminationRequest $request)
    {
        Termination::create($request->validated());

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data pemberhentian kerja.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['item'] = Termination::select([
            'terminations.id', 'terminations.subject',
            'terminations.notice_date',
            'terminations.termination_date',
            'terminations.description',
            'terminations.created_at',
            'terminations.updated_at',
            'terminations.termination_type_id',
            'terminations.employee_id',
            'termination_types.name AS termination_type',
            'employees.full_name',
            'employees.number',
            'employees.photo'
        ])->join('termination_types', 'terminations.termination_type_id', '=', 'termination_types.id')
        ->join('employees', 'terminations.employee_id', '=', 'employees.id')
        ->find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.admin.termination.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['item'] = Termination::select([
            'terminations.id', 'terminations.subject',
            'terminations.notice_date',
            'terminations.termination_date',
            'terminations.description',
            'terminations.termination_type_id',
            'terminations.employee_id',
        ])->find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['termination_types'] = TerminationType::select([
            'id', 'name'
        ])->orderBy('name')
        ->get();

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

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.admin.termination.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Termination::select([
            'terminations.id', 'terminations.subject',
            'terminations.notice_date',
            'terminations.termination_date',
            'terminations.description',
            'terminations.termination_type_id',
            'terminations.employee_id',
        ])->find($id);

        if ($item === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'employee_id' => [
                'required', 'string',
                'exists:employees,id',
                Rule::unique('terminations')->ignore($id)
            ],
            'termination_type_id' => [
                'required', 'string',
                'exists:termination_types,id',
            ],
            'subject' => [
                'required', 'string',
                'max:255'
            ],
            'notice_date' => [
                'required',
                Rule::date()->format('Y-m-d')
            ],
            'termination_date' => [
                'required',
                Rule::date()->format('Y-m-d'),
                'after_or_equal:notice_date'
            ],
            'description' => [
                'required', 'string',
                'max:65535'
            ]
        ], [], [
            'employee_id' => 'Pegawai',
            'termination_type_id' => 'Jenis Pemberhentian',
            'subject' => 'Subyek',
            'notice_date' => 'Tanggal Pemberitahuan',
            'termination_date' => 'Tanggal Pemberhentian Kerja',
            'description' => 'Deskripsi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        Termination::where('id', $id)
                    ->limit(1)
                    ->update($validator->validated());

        return redirect()->route('admin.terminations.index')
                    ->with('success', 'Berhasil mengubah data pemberhentian kerja.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Termination::select([
            'terminations.id'
        ])->find($id);

        if ($item === null) {
            abort(404);
        }

        $item->delete();

        return redirect()->route('admin.terminations.index')
                        ->with('success', 'Berhasil menghapus data pemberhentian kerja.');
    }
}
