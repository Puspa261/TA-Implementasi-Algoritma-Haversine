<?php

namespace App\Http\Controllers;

use App\Models\histori_lokasi;
use App\Models\jabatan;
use App\Models\lokasi;
use App\Models\pangkat;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query_data = User::with('jabatan');

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('name', 'like', $search_value)
                            ->orWhere('nip', 'like', $search_value)
                            ->orWhereHas('jabatan', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            });
                    });
            }

            $data = $query_data->orderBy('name', 'asc')->orderBy('id_jabatan', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('user.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . ' <a class="btn btn-primary edit-btn" href="' . route('user.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('user.destroy', $row->id) . '"method="POST"
                                    onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';

                    if (Auth::user()->can('admin-delete')) {
                        $btn = $btn . csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger delete-btn"> 
                                            <i class="bx bx-trash"></i>
                                    </button>';
                    }

                    $btn = $btn . '</form> </div>';
                    return $btn;
                })
                ->addColumn('jabatan', function ($row) {
                    return $row->jabatan->detail . " " . $row->jabatan->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::orderBy('detail', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        $pangkats = pangkat::orderBy('golongan', 'asc')->get();
        $roles = Role::pluck('name', 'name')->all();

        // dd($jabatans, $roles);
        return view('user.create', compact('jabatans', 'roles', 'pangkats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'numeric',
                'password' => 'same:confirm-password',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ], [
                'nip.numeric' => 'NIP user wajib berisikan angka',
            ]);

            $input = $request->all();

            $input['password'] = Hash::make($request->password);


            if ($image = $request->file('image')) {
                $destinationPath = 'imageUser/';
                $profileImage = $request->name . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = $profileImage;
            } else {
                $input['image'] = 'ikon.jpg';
            }

            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            return redirect()->route('user.index')
                ->with('success', 'Data Pegawai berhasil dibuat');
        } catch (QueryException $e) {
            // Tangkap pengecualian duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
            }

            // Tangkap pengecualian lainnya jika diperlukan
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        $userid = $user->id;
        $lokasis = histori_lokasi::where('id_pegawai', $userid)->get();

        return view('user.show', [
            'user' => $user,
            'lokasis' => $lokasis,
        ]);
    }

    public function show_lokasi($id)
    {
        $histori_lokasi = histori_lokasi::find($id);
        // dd($histori_lokasi->pegawai);
        return view('user.showLokasi', [
            'histori_lokasi' => $histori_lokasi
        ]);

        // dd($lokasi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $jabatans = Jabatan::orderBy('detail', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        $pangkats = pangkat::orderBy('golongan', 'asc')->get();
        $roles = Role::pluck('name', 'name')->all();
        $user = User::find($user->id);
        return view('user.edit', compact('user', 'jabatans', 'roles', 'pangkats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'numeric',
            'password' => 'same:confirm-password',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'nip.numeric' => 'NIP user wajib berisikan angka',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if ($image = $request->file('image')) {
            $destinationPath = 'imageUser/';
            $profileImage = $request->name . "-" . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        } else {
            unset($input['image']);
        }

        $user = user::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')
            ->with('success', 'Data Pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        DB::table('users')->where('name', '=', $user->name)->delete();
        $user->delete();


        return redirect()->route('user.index')
            ->with('success', 'Data Pegawai berhasil dihapus');
    }
}
