<?php

namespace App\Http\Controllers;

use App\Models\detail_regu;
use App\Models\regu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReguController extends Controller
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

            $query_data = new regu();

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
                        <a class="btn btn-info show-btn" href="' . route('regu.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . '<a class="btn btn-primary edit-btn" href="' . route('regu.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('regu.destroy', $row->id) . '"method="POST"
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

        return view('regu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('regu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        regu::create($input);

        return redirect()->route('regu.index')
            ->with('success', 'Regu berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(regu $regu)
    {
        // dd($regu);
        return view('regu.show', [
            'regu' => $regu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $regu = regu::find($id);
        return view('regu.edit', compact('regu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $regu = regu::find($id);
        $regu->update($input);

        return redirect()->route('regu.index')
            ->with('success', 'Regu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $regu = regu::find($id);
        $regu->delete();

        return redirect()->route('regu.index')
            ->with('success', 'Regu berhasil dihapus');
    }
}
