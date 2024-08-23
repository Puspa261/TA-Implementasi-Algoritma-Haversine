<?php

namespace App\Http\Controllers;

use App\Models\detail_regu;
use App\Models\jabatan_tugas;
use App\Models\regu;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DetailReguController extends Controller
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

            $query_data = detail_regu::with('regu', 'user', 'jabatan_tugas');

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('regu', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            })
                            ->orWhere('user', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            })
                            ->orWhereHas('jabatan_tugas', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            });
                    });
            }

            $data = $query_data->orderBy('id_regu', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('detail_regu.show', $row->id) . '"> 
                                <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . ' <a class="btn btn-primary edit-btn" href="' . route('detail_regu.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('detail_regu.destroy', $row->id) . '"method="POST"
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
                ->addColumn('regu', function ($row) {
                    if ($row->regu != null) {
                        return $row->regu->name;
                    } else {
                        return "";
                    }
                })
                ->addColumn('jabatan_tugas', function ($row) {
                    foreach ($row->jabatan_tugas as $jt) {
                        return $jt->name;
                    }
                })
                ->addColumn('user', function ($row) {
                    foreach ($row->user as $user) {
                        return $user->name;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('detailRegu.index');
    }

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {

    //         $query_data = detail_regu::with('regu:id,name')
    //                     ->select('id_regu', DB::raw('GROUP_CONCAT(id_user) AS user'))
    //                     ->groupBy('id_regu');

    //         if ($request->sSearch) {
    //             $search_value = '%' . $request->sSearch . '%';
    //             $query_data = $query_data
    //                 ->where(function ($query) use ($search_value) {
    //                     $query
    //                         ->where('regu', function ($query) use ($search_value) {
    //                             $query->where('name', 'like', $search_value);
    //                         });
    //                 });
    //         }

    //         $data = $query_data->orderBy('id_regu', 'asc')->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '
    //                 <div class="d-flex flex-column align-items-center">
    //                     <a class="btn btn-info show-btn" href="' . '' . '"> 
    //                             <i class="bx bx-search-alt"></i>
    //                     </a>';

    //                 if (Auth::user()->can('admin-edit')) {
    //                     $btn = $btn . ' <a class="btn btn-primary edit-btn" href="' . '' . '"> 
    //                                         <i class="bx bx-edit"></i>
    //                                     </a>';
    //                 }

    //                 $btn = $btn . '<form action="' . '' . '"method="POST"
    //                                 onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';

    //                 if (Auth::user()->can('admin-delete')) {
    //                     $btn = $btn . csrf_field() . method_field('DELETE') .
    //                         '<button type="submit" class="btn btn-danger delete-btn"> 
    //                                         <i class="bx bx-trash"></i>
    //                                 </button>';
    //                 }

    //                 $btn = $btn . '</form> </div>';
    //                 return $btn;
    //             })
    //             ->addColumn('regu', function ($row) {
    //                 return $row->regu->name;
    //             })
    //             // ->addColumn('jabatan_tugas', function ($row) {
    //             //     foreach ($row->jabatan_tugas as $jt) {
    //             //         return $jt->name;
    //             //     }
    //             // })
    //             // ->addColumn('user', function ($row) {
    //             //     foreach ($row->user as $user) {
    //             //         return $user->name;
    //             //     }
    //             // })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('detailRegu.index');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regu = regu::orderBy('name', 'asc')->get();
        $jabatan_tugas = jabatan_tugas::orderBy('name', 'asc')->get();
        $user = User::orderBy('name', 'asc')->get();

        return view('detailRegu.create', compact('regu', 'jabatan_tugas', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $regu = $request->id_regu;
            $user = $request->id_pegawai;
            $jabatan_tugas = $request->id_jabatan_tugas;
            $insertData = [];

            for ($i = 0; $i < count($user); $i++) {
                array_push(
                    $insertData,
                    [
                        'id_regu' => $regu,
                        'id_pegawai' => $user[$i],
                        'id_jabatan_tugas' => $jabatan_tugas
                    ]
                );
            }

            detail_regu::insertOrIgnore($insertData);

            return redirect()->route('detail_regu.index')
                ->with('success', 'Detail Regu berhasil dibuat');
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(detail_regu $detail_regu)
    {
        return view('detailRegu.show', [
            'detail_regu' => $detail_regu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(detail_regu $detail_regu)
    {
        $regu = regu::orderBy('name', 'asc')->get();
        $jabatan_tugas = jabatan_tugas::orderBy('name', 'asc')->get();
        $user = User::orderBy('name', 'asc')->get();

        // dd($detail_regu);
        return view('detailRegu.edit', compact('regu', 'jabatan_tugas', 'user', 'detail_regu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detail_regu $detail_regu)
    {
        $input = $request->all();

        $detail_regu->update($input);

        return redirect()->route('detail_regu.index')
            ->with('success', 'Detail Regu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detail_regu $detail_regu)
    {
        $detail_regu->delete();

        return redirect()->route('detail_regu.index')
            ->with('success', 'Detail Regu berhasil diperbarui');
    }
}
