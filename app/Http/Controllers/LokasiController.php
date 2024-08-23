<?php

namespace App\Http\Controllers;

use App\Models\histori_lokasi;
use App\Models\lokasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{

    function __construct()
    {

        $this->middleware(
            'permission:admin-list|admin-create|admin-edit|admin-delete|user-list|user-create|user-edit|user-delete',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:admin-create|user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit|user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete|user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query_data = lokasi::with('pegawai');

            $today = Carbon::today();
            $query_data = $query_data->whereDate('updated_at', $today);

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('id_pegawai', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            })
                            ->orWhere('location', 'like', $search_value);
                    });
            }

            $data = $query_data->orderBy('id_pegawai', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('lokasi.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>
                    </div>';
                    return $btn;
                })
                ->addColumn('updated_at', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d-m-Y');
                })
                ->addColumn('petugas', function ($row) {
                    foreach ($row->pegawai as $pegawai) {
                        return $pegawai->name;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('lokasi.index');
    }

    public function pegawai(Request $request)
    {
        if ($request->ajax()) {

            $query_data = histori_lokasi::where('id_pegawai', auth()->user()->id);

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where('location', 'like', $search_value);
            }

            $data = $query_data->orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                <div class="d-flex flex-column align-items-center">
                    <a class="btn btn-info show-btn" href="' . route('histori.lokasi', $row->id) . '"> 
                        <i class="bx bx-search-alt"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d-m-Y / H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('historiLokasi.pegawai');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = User::where('nip', Auth::user()->nip)->first();
        $lokasi = lokasi::where('id_pegawai', '=', $pegawai->id)->first();
        // dd($lokasi);

        return view('lokasi.create', [
            'pegawai' => $pegawai,
            'lokasi' => $lokasi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'location.required' => 'Lokasi Wajib di Isi!!!',
            'latitude.required' => 'Latitude Wajib di Isi!!!',
            'longitude.required' => 'Longitude Wajib di Isi!!!',
        ]);
        
        // dd($request->all());
        $input = $request->all();

        $lokasi = lokasi::where('id_pegawai', '=', $input['id_pegawai'])->first();
        // dd($lokasi);
        if ($lokasi == null) {
            lokasi::create($input);
            histori_lokasi::create($input);

            return redirect()->route('lokasi.create')
                ->with('success', 'Lokasi berhasil diperbarui');
        } else {
            lokasi::where('id_pegawai', '=', $input['id_pegawai'])->update([
                'location' => $input['location'],
                'latitude' => $input['latitude'],
                'longitude' => $input['longitude']
            ]);
            histori_lokasi::create($input);

            return redirect()->route('lokasi.create')
                ->with('success', 'Lokasi berhasil diperbarui');
        }
    }

    public function show($id)
    {
        $lokasi = lokasi::find($id);

        return view('lokasi.show', [
            'histori_lokasi' => $lokasi
        ]);

        // dd($lokasi);
    }

    public function histori_lokasi($id)
    {
        $histori_lokasi = histori_lokasi::find($id);
        // dd($histori_lokasi);
        return view('historiLokasi.show', compact('histori_lokasi'));

        // dd($lokasi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(lokasi $lokasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, lokasi $lokasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(lokasi $lokasi)
    {
        // dd($lokasi);
        $lokasi->delete();

        return redirect()->back()
            ->with('success', 'Lokasi berhasil dimatikan');
    }
}
