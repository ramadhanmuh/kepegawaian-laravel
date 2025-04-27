<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreUserRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
                                        
        return view('pages.super-admin.user.index', $data);
    }

    function list(Request $request): JsonResponse
    {
        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
            4 => 'role',
        ];

        $length = $request->input('length');

        $length = $length === null || $length > 100 ? 10 : $length;

        $column = $request->input('order.0.column');

        $column = array_key_exists($column, $columns) ? $column : 1;

        $dir = $request->input('order.0.dir');

        $dir = $dir === 'asc' || $dir === 'ASC' || $dir === 'desc' || $dir === 'DESC'
                ? $dir
                : 'asc';

        $searchValue = $request->input('search.value');

        $query = User::select('id', 'name', 'email', 'phone', 'role')
                     ->when($searchValue, function($query, $searchValue) {
                         $query->where(function($q) use ($searchValue) {
                             $q->where('name', 'like', "%{$searchValue}%")
                               ->orWhere('email', 'like', "%{$searchValue}%")
                               ->orWhere('phone', 'like', "%{$searchValue}%")
                               ->orWhere('role', 'like', "%{$searchValue}%");
                         });
                     });

        $totalFiltered = $query->count();

        $users = $query->orderBy($columns[$column], $dir)
                       ->offset($request->input('start'))
                       ->limit($length)
                       ->limit(10)
                       ->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => User::count(),
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

        return view('pages.super-admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->back()
                        ->with('success', 'Berhasil membuat data pengguna.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
