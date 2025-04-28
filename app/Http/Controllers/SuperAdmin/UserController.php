<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreUserRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        $role = $request->role;

        $query = User::query();

        $query = $query->select('id', 'name', 'email', 'phone', 'role');

        if (is_string($role) && !empty($role)) {
            $query->where('role', $role);
        }

        if (is_string($searchValue) && !empty($searchValue)) {
            $query = $query->when($searchValue, function($query, $searchValue) {
                                $query->where(function($q) use ($searchValue) {
                                    $q->where('name', 'like', "%{$searchValue}%")
                                    ->orWhere('email', 'like', "%{$searchValue}%")
                                    ->orWhere('phone', 'like', "%{$searchValue}%")
                                    ->orWhere('role', 'like', "%{$searchValue}%");
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
    public function show(string $id): View
    {
        $data['item'] = User::select([
            'id', 'name', 'email', 'phone',
            'role', 'created_at', 'updated_at'
        ])->find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        return view('pages.super-admin.user.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['item'] = User::select([
            'id', 'name', 'email', 'phone',
            'role', 'created_at', 'updated_at'
        ])->where('id', $id)
        ->where('id', '!=', Auth::user()->id)
        ->where('role', '!=', 'super_admin')
        ->first();

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        return view('pages.super-admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $item = User::select([
            'id', 'name', 'email', 'phone',
            'role', 'created_at', 'updated_at'
        ])->where('id', $id)
        ->where('id', '!=', Auth::user()->id)
        ->where('role', '!=', 'super_admin')
        ->first();

        if ($item === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string',
                'max:255',
            ],
            'email' => [
                'required', 'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => [
                'nullable', 'string',
            ],
            'phone' => [
                'required', 'string',
                Rule::unique('users')->ignore($id),
            ],
            'role' => [
                'required', 'string',
                'in:admin,super_admin'
            ]
        ], [], [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'phone' => 'Nomor Telepon Genggam',
            'role' => 'Jenis'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $validator->validated();

        $input['password'] = $input['password'] === null
                                ? $item->password
                                : Hash::make($input['password']);

        User::where('id', $id)
            ->limit(1)
            ->update($input);

        return redirect()->route('super-admin.users.index')
                        ->with('success', 'Berhasil mengubah data pengguna.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $item = User::select([
            'id', 'name', 'email', 'phone',
            'role', 'created_at', 'updated_at'
        ])->where('id', $id)
        ->where('id', '!=', Auth::user()->id)
        ->where('role', '!=', 'super_admin')
        ->first();

        if ($item === null) {
            abort(404);
        }

        $item->delete();

        return redirect()->route('super-admin.users.index')
                        ->with('success', 'Berhasil menghapus data pengguna.');
    }
}
