<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Application;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        
        return view('pages.admin.employee.index', $data);
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
        ])->join('designations', 'employees.designation_id', '=', 'designations.id');

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
        ])->orderBy('name', 'ASC')
        ->get();
        
        return view('pages.admin.employee.create', $data);
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
        $data['item'] = Employee::select([
            'employees.full_name', 'employees.number',
            'employees.email', 'employees.phone',
            'employees.gender', 'employees.religion',
            'employees.place_of_birth',
            'employees.date_of_birth',
            'employees.date_of_joining',
            'employees.marital_status',
            'employees.photo', 'employees.address',
            'employees.created_at', 'employees.updated_at',
            'designations.name as designation',
            'employees.id'
        ])->leftJoin('designations', 'employees.designation_id', '=', 'designations.id')
        ->where('employees.id', $id)
        ->first();

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();
        
        return view('pages.admin.employee.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['item'] = Employee::find($id);

        if ($data['item'] === null) {
            abort(404);
        }

        $data['application'] = Application::select([
            'name', 'copyright', 'favicon'
        ])->first();

        $data['designations'] = Designation::select([
            'id', 'name'
        ])->orderBy('name', 'ASC')
        ->get();
        
        return view('pages.admin.employee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Employee::find($id);

        if ($item === null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => [
                'required', 'string', 'max:255'
            ],
            'number' => [
                'required', 'string', 'max:255',
                Rule::unique('employees')->ignore($item->id),
            ],
            'designation_id' => [
                'required', 'string', 'exists:designations,id'
            ],
            'email' => [
                'nullable', 'email', 'max:255',
                Rule::unique('employees')->ignore($item->id),
            ],
            'phone' => [
                'required', 'string', 'max:255',
                Rule::unique('employees')->ignore($item->id),
            ],
            'gender' => [
                'required', 'string', 'in:pria,wanita'
            ],
            'religion' => [
                'required', 'string',
                'in:islam,kristen_protestan,kristen_katolik,hindu,buddha,konghucu'
            ],
            'place_of_birth' => [
                'required', 'string', 'max:255'
            ],
            'date_of_birth' => [
                'required', 'string', 'date_format:Y-m-d'
            ],
            'date_of_joining' => [
                'required', 'string', 'date_format:Y-m-d'
            ],
            'marital_status' => [
                'required', 'string',
                'in:belum_menikah,sudah_menikah'
            ],
            'photo' => [
                'nullable', 'file', 'mimes:jpg,jpeg,png',
                'max:5120'
            ],
            'address' => [
                'required', 'string', 'max:65535'
            ],
        ], [], [
            'full_name' => 'Nama Lengkap',
            'number' => 'Nomor Pegawai',
            'designation_id' => 'Jabatan',
            'email' => 'Email',
            'phone' => 'Nomor Telepon Genggam',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'place_of_birth' => 'Tempat Lahir',
            'date_of_birth' => 'Tanggal Lahir',
            'date_of_joining' => 'Tanggal Bergabung',
            'marital_status' => 'Status Pernikahan',
            'photo' => 'Foto',
            'address' => 'Alamat',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $validator->safe()->except(['photo']);

        if ($request->hasFile('photo')) {
            $photoFileDestinationPath = 'uploads/employee/photo';

            $photoFileDestinationFullPath = public_path($photoFileDestinationPath);

            $photoFile = $request->file('photo');

            $photoFileName = Str::random(40)
                            . '.'
                            . $photoFile->getClientOriginalExtension(); 

            $photoFile->move($photoFileDestinationFullPath, $photoFileName);

            $input['photo'] = $photoFileDestinationPath . '/' . $photoFileName;

            File::delete($item->photo);
        } else {
            $input['photo'] = $item->photo;
        }

        Employee::where('id', $id)
                ->limit(1)
                ->update($input);

        return redirect()->route('admin.employees.index')
                        ->with('success', 'Berhasil mengubah data pegawai.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Employee::select(['id', 'photo'])
                        ->find($id);

        if ($item === null) {
            abort(404);
        }

        File::delete($item->photo);

        $item->delete();

        return redirect()->back()
                        ->with('success', 'Berhasil menghapus data pegawai.');
    }
}
