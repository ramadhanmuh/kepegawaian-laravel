<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Models\Application;
use App\Models\Designation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.admin.designation.index', $data);
    }

    function list(Request $request): JsonResponse
    {
        $columns = [
            'id', 'name', 'created_at', 'updated_at'
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

        $query = Designation::query();

        $query = $query->select([
            'id', 'name', 'created_at', 'updated_at'
        ]);

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('name', 'like', "%{$searchValue}%");
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
            'recordsTotal' => Designation::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        return view('pages.admin.designation.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $request): RedirectResponse
    {
        Designation::create($request->validated());

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data jabatan.');
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
    public function edit(string $id): View
    {
        $data['item'] = Designation::find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        return view('pages.admin.designation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $item = Designation::find($id);

        if ($item === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string',
                'max:255',
            ],
        ], [], [
            'name' => 'Nama',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        Designation::where('id', '=', $id)
                    ->limit(1)
                    ->update([
                        'name' => $request->name
                    ]);

        return redirect()->route('admin.designations.index')
                        ->with('success', 'Berhasil mengubah data jabatan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $item = Designation::find($id);

        if ($item === null) {
            abort(404);
        }

        $item->delete();

        return redirect()->route('admin.designations.index')
                        ->with('success', 'Berhasil menghapus data jabatan.');
    }
}
