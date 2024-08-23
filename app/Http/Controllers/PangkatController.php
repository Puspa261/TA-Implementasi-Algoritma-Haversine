<?php

namespace App\Http\Controllers;

use App\Models\pangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PangkatController extends Controller
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

        if ($request->ajax()) {

            $query_data = new pangkat();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('pangkat', 'like', $search_value)
                            ->orWhere('golongan', 'like', $search_value);
                    });
            }

            $data = $query_data->orderBy('golongan', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('pangkat.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . '<a class="btn btn-primary edit-btn" href="' . route('pangkat.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('pangkat.destroy', $row->id) . '"method="POST"
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
                ->addColumn('pangkat', function ($row) {
                    // return $row->date;
                    return $row->pangkat . " / " . $row->golongan;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pangkat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pangkat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        pangkat::create($input);

        return redirect()->route('pangkat.index')
            ->with('success', 'Pangkat / Golongan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(pangkat $pangkat)
    {
        return view('pangkat.show', [
            'pangkat' => $pangkat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pangkat $pangkat)
    {
        return view('pangkat.edit', compact('pangkat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pangkat $pangkat)
    {
        $input = $request->all();

        $pangkat->update($input);

        return redirect()->route('pangkat.index')
            ->with('success', 'Pangkat / Golongan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pangkat $pangkat)
    {
        $pangkat->delete();

        return redirect()->route('pangkat.index')
            ->with('success', 'Pangkat / Golongan berhasil dihapus');
    }
}
