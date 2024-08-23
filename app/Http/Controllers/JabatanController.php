<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class JabatanController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('jabatan.index');

        if ($request->ajax()) {

            $query_data = new jabatan();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('name', 'like', $search_value)
                            ->orWhere('detail', 'like', $search_value);
                    });
            }

            $data = $query_data->orderBy('detail', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('jabatan.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . '<a class="btn btn-primary edit-btn" href="' . route('jabatan.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('jabatan.destroy', $row->id) . '"method="POST"
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
                ->addColumn('name', function ($row) {
                    return $row->name != null ? $row->name : "-";
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        jabatan::create($input);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(jabatan $jabatan)
    {
        return view('jabatan.show', [
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jabatan $jabatan)
    {
        $input = $request->all();

        $jabatan->update($input);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jabatan $jabatan)
    {
        // $input = $request->all();
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus');
    }
}
