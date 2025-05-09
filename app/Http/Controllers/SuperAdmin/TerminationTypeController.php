<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTerminationTypeRequest;
use App\Models\Application;
use App\Models\TerminationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerminationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.termination-type.index', $data);
    }

    function list(Request $request)
    {
        $columns = [
            'id', 'name', 'description',
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

        $query = TerminationType::query();

        $query = $query->select([
            'id', 'name', 'description'
        ]);

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('name', 'like', "%{$searchValue}%")
                                        ->orWhere('description', 'like', "%{$searchValue}%");
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
            'recordsTotal' => TerminationType::count(),
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
        
        return view('pages.super-admin.termination-type.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTerminationTypeRequest $request)
    {
        TerminationType::create($request->validated());

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data jenis pemberhentian kerja.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['item'] = TerminationType::find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.termination-type.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['item'] = TerminationType::find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.super-admin.termination-type.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = TerminationType::find($id);

        if ($item === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string', 'max:255',
            ],
            'description' => [
                'required', 'string', 'max:65535'
            ]
        ], [], [
            'name' => 'Nama',
            'description' => 'Deskripsi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $validator->validated();

        TerminationType::where('id', $id)
                        ->limit(1)
                        ->update($input);

        return redirect()->route('super-admin.termination-types.index')
                        ->with('success', 'Berhasil mengubah data jenis pemberhentian kerja.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
