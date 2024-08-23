<?php

namespace App\Http\Controllers;

use App\Models\detail;
use App\Models\regu;
use App\Models\surat_tugas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SuratTugasController extends Controller
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

            $query_data = surat_tugas::with('detail');

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('date', 'like', $search_value)
                            ->orWhere('location', 'like', $search_value);
                    });
            }

            $data = $query_data->orderBy('created_at', 'desc')->get();
            $data = $query_data->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('surat_tugas.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . ' <a class="btn btn-primary edit-btn" href="' . route('surat_tugas.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('surat_tugas.destroy', $row->id) . '"method="POST"
                                    onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';

                    if (Auth::user()->can('admin-delete')) {
                        $btn = $btn . csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger delete-btn"> 
                                            <i class="bx bx-trash"></i>
                                    </button>
                                    </form>';
                    }

                    if (Auth::user()->can('admin-create')) {
                        $btn = $btn . '<a class="btn btn-success show-btn" href="' . route('detail_tugas', $row->id) . '"> 
                        <i class="bx bx-printer"></i>
                        </a>';
                    }

                    $btn = $btn . '</div>';

                    return $btn;
                })
                ->addColumn('date', function ($row) {
                    // return $row->date;
                    return Carbon::parse($row->date)->translatedFormat('d-m-Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('suratTugas.index');
    }

    // public function pegawai()
    // {
    //     $data = User::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    //     return response()->json($data);
    // }

    public function pegawai(Request $request)
    {
        $search = $request->input('q');
        $query = User::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->orderBy('name')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $regu = regu::orderBy('name')->get();
        $user = User::orderBy('name')->get();

        // dd($lokasi, $user);
        return view('suratTugas.create', compact('regu', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $no_surat = $request->nosurat;
        $no_surat = $request->nosurat;
        $tanggal = $request->date;
        $mulai = $request->started_at;
        $selesai = $request->finished_at;
        $regu = $request->id_regu;
        $keterangan = $request->keterangan;
        $lokasi = $request->location;
        $tikum = $request->tikum;
        $tikum = $request->tikum;
        $user = $request->id_pegawai;
        $tanggal_buat = $request->tanggal_pembuatan;
        $tanggal_buat = $request->tanggal_pembuatan;

        $surat_tugas = surat_tugas::create([
            'nosurat' => $no_surat,
            'nosurat' => $no_surat,
            'date' => $tanggal,
            'started_at' => $mulai,
            'finished_at' => $selesai,
            'location' => $lokasi,
            'tikum' => $tikum,
            'tikum' => $tikum,
            'id_pegawai' => $user,
            'tanggal_pembuatan' => $tanggal_buat,
            'tanggal_pembuatan' => $tanggal_buat,
        ]);

        for ($k = 0; $k < count($keterangan); $k++) {

            detail::create(
                [
                    'id_surat_tugas' => $surat_tugas->id,
                    'id_regu' => $regu[$k],
                    'keterangan' => $keterangan[$k],
                ]
            );
        }

        return redirect()->route('surat_tugas.index')
            ->with('success', 'Surat Tugas berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $surat_tugas = surat_tugas::find($id);
        $details = detail::where('id_surat_tugas', $surat_tugas->id)->get();

        $regus = [];
        foreach ($details as $detail) {
            $regus[] = Regu::find($detail->id_regu);
        }

        return view('suratTugas.show', [
            'surat_tugas' => $surat_tugas,
            'details' => $details,
            'regus' => $regus,
            // 'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $surat_tugas = surat_tugas::find($id);
        $details = detail::where('id_surat_tugas', $surat_tugas->id)->get();

        $regus = [];
        foreach ($details as $detail) {
            $regus[] = Regu::find($detail->id_regu);
        }

        // $surat_tugas = surat_tugas::find($id);
        // $detail = detail::find($id);
        $regu = regu::all();
        $user = User::orderBy('name')->get();

        return view('suratTugas.edit', compact('surat_tugas', 'details', 'regus', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $surat_tugas = surat_tugas::find($id);
        // $detail = detail::find($id);

        $surat_tugas->update($input);
        // $detail->update($input);

        return redirect()->route('surat_tugas.index')
            ->with('success', 'Surat Tugas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ids)
    {
        $idsArray = explode(',', $ids);

        foreach ($idsArray as $id) {
            $surat_tugas = surat_tugas::find($id);
            $details = detail::where('id_surat_tugas', $id)->get();

            $surat_tugas->delete();

            $details->each->delete();
        }

        return redirect()->route('surat_tugas.index')
            ->with('success', 'Surat Tugas berhasil dihapus');
    }


    function exportPdf(Request $request, $id)
    {
        $surat_tugas = surat_tugas::find($id);
        $details = detail::where('id_surat_tugas', $surat_tugas->id)->get();

        // dd($details);
        if ($surat_tugas->user->pangkat == null) {
            return redirect()->back()
                ->with('error', 'Pangkat Penandatangan Kosong!!!');
        } else {
            $pdf = Pdf::loadView('suratTugas.pdf', [
                'surat_tugas' => $surat_tugas,
                'details' => $details,
                'dasar' => $request->dasar,
                'tugas' => $request->tugas,
            ]);

            //Set Landscape
            // $pdf->setPaper('A4');

            // Untuk Download
            // return $pdf->download('LaporanProduct.pdf');

            // Nama File PDF
            return $pdf->stream('Surat_Tugas_' . $request->nomor . '.pdf');
        }
    }

    public function detail_tugas($id)
    {
        return view('suratTugas.detailTugas', compact('id'));
    }

    public function st_user()
    {
        $user = Auth::user();
        // $today = Carbon::now()->toDateString();

        $surat_tugas = surat_tugas::whereHas('detail.regu.detail_regu', function ($query) use ($user) {
            $query->where('id_pegawai', $user->id);
        })
            ->with(['detail' => function ($query) {
                $query->with(['regu.detail_regu' => function ($queryDetailRegu) {
                    $queryDetailRegu->with('user');
                }]);
            }])
            ->orderBy('date', 'desc')
            ->get();
        return view('suratTugas.pegawai', compact('surat_tugas'));
    }

    public function show_pegawai($id)
    {
        $user = Auth::user();

        $surat_tugas = surat_tugas::find($id);

        // $details = detail::where('id_surat_tugas', $surat_tugas->id)->get();
        $detail = detail::where('id_surat_tugas', $id)
            ->whereHas('regu.detail_regu', function ($query) use ($user) {
                $query->where('id_pegawai', $user->id);
            })
            ->first();

        // dd($detail);

        $regu = regu::find($detail->id_regu);

        return view('suratTugas.showPegawai', [
            'surat_tugas' => $surat_tugas,
            'detail' => $detail,
            'regu' => $regu,
            // 'users' => $users,
        ]);
    }

    public function map()
    {
        return view('suratTugas.maps');
    }
}
