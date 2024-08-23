<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    function __construct()
    {

        $this->middleware(
            'permission:admin-list|admin-create|admin-edit|admin-delete',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }

    public function index_old(Request $request)
    {

        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('role.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function index(Request $request)
    {
        // return view('jabatan.index');

        if ($request->ajax()) {

            $query_data = new Role();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('name', 'like', $search_value);
                    });
            }

            $data = $query_data->orderBy('name', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('role.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . '<a class="btn btn-primary edit-btn" href="' . route('role.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('role.destroy', $row->id) . '"method="POST"
                                    onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';

                    if (Auth::user()->can('admin-delete')) {
                        $btn = $btn . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger delete-btn"> 
                                        <i class="bx bx-trash"></i>
                                    </button>';
                    }

                    $btn = $btn . '</form></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('role.index');
    }

    public function create()
    {

        $permission = Permission::get();
        return view('role.create', compact('permission'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ], [
            'name.required' => 'Role wajib di isi',
            'permission.required' => 'Hak Akses wajib di isi',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('role.index')
            ->with('success', 'Role berhasil dibuat');
    }

    public function show($id)
    {

        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        // dd($rolePermissions);
        return view('role.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {

        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck("role_has_permissions.permission_id", "role_has_permissions.permission_id")
            ->all();

        return view('role.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ], [
            'name.required' => 'Role wajib di isi',
            'permission.required' => 'Permission wajib di isi',
        ]);

        $role = Role::find($id);

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('role.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {

        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('role.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
