<?php

namespace App\Http\Controllers;

use App\Models\lokasi;
use App\Models\pengaduan_masyarakat;
use App\Models\respon_laporan;
use App\Models\tindak_lanjut;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class PengaduanMasyarakatController extends Controller
{
    function __construct()
    {

        $this->middleware(
            'permission:admin-list|admin-edit|admin-delete|user-list',
            ['only' => ['index']]
        );
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query_data = pengaduan_masyarakat::with('pegawai');

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('jenis', 'like', $search_value)
                            ->orWhere('name', 'like', $search_value)
                            ->orWhere('status', 'like', $search_value)
                            ->orWhereHas('pegawai', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            });
                    });
            }

            $data = $query_data->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('pengaduan_masyarakat.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn = $btn . ' <a class="btn btn-primary edit-btn" href="' . route('pengaduan_masyarakat.edit', $row->id) . '"> 
                                            <i class="bx bx-edit"></i>
                                        </a>';
                    }

                    $btn = $btn . '<form action="' . route('pengaduan_masyarakat.destroy', $row->id) . '"method="POST"
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
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d-m-Y / H:i:s');
                })
                ->addColumn('status', function ($row) {
                    $tanggapan = tindak_lanjut::where('id_pengaduan', $row->id)->exists();

                    if (!$tanggapan) {
                        $status = '<p class="text-danger pt-3">belum ditanggapi</p>';
                    } else {
                        $status = '<p class="text-success pt-3">sudah ditanggapi</p>';
                    }

                    return $status;
                })
                ->addColumn('pegawai', function ($row) {
                    if ($row->pegawai != null) {
                        foreach ($row->pegawai as $pegawai) {
                            return $pegawai->name;
                        }
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('landingPage.admin');
    }

    public function pegawai(Request $request)
    {
        if ($request->ajax()) {

            // Mulai query dengan relasi 'pegawai'
            $query_data = pengaduan_masyarakat::with('pegawai')
                ->where('id_pegawai', Auth::user()->id);

            // Menambahkan pencarian jika ada
            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data
                    ->where(function ($query) use ($search_value) {
                        $query
                            ->where('date', 'like', $search_value)
                            ->orWhere('name', 'like', $search_value)
                            ->orWhere('status', 'like', $search_value)
                            ->orWhereHas('pegawai', function ($query) use ($search_value) {
                                $query->where('name', 'like', $search_value);
                            });
                    });
            }

            // Mengurutkan data berdasarkan 'date'
            $query_data = $query_data->orderBy('created_at', 'desc')->get();

            return DataTables::of($query_data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="d-flex flex-column align-items-center">
                        <a class="btn btn-info show-btn" href="' . route('pengaduan_masyarakat.show', $row->id) . '"> 
                            <i class="bx bx-search-alt"></i>
                        </a>';

                    if (Auth::user()->can('admin-edit')) {
                        $btn .= ' <a class="btn btn-primary edit-btn" href="' . route('pengaduan_masyarakat.edit', $row->id) . '"> 
                                        <i class="bx bx-edit"></i>
                                    </a>';
                    }

                    $btn .= '<form action="' . route('pengaduan_masyarakat.destroy', $row->id) . '" method="POST"
                                 onsubmit="return confirm(\'Are you sure you want to delete this item?\')">';

                    if (Auth::user()->can('admin-delete')) {
                        $btn .= csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger delete-btn"> 
                                        <i class="bx bx-trash"></i>
                                </button>';
                    }

                    $btn .= '</form> </div>';
                    return $btn;
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d-m-Y / H:i:s');
                })
                ->addColumn('status', function ($row) {
                    $tanggapan = tindak_lanjut::where('id_pengaduan', $row->id)->exists();

                    if (!$tanggapan) {
                        $status = '<p class="text-danger pt-3">belum ditanggapi</p>';
                    } else {
                        $status = '<p class="text-success pt-3">sudah ditanggapi</p>';
                    }

                    return $status;
                })
                ->addColumn('pegawai', function ($row) {
                    // return $row->pegawai->name;
                    foreach ($row->pegawai as $pegawai) {
                        return $pegawai->name;
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('landingPage.pegawai');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pengaduan_masyarakat = pengaduan_masyarakat::with('pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // ->get()

        // return view('landingPage.index', [
        //     'pengaduan_masyarakat' => $pengaduan_masyarakat,
        // ]);

        return view('landingPage.index', compact('pengaduan_masyarakat'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function getTindakLanjut($id)
    {
        $tindaklanjut = tindak_lanjut::where('id_pengaduan', '=', $id)->first();
        return response()->json([
            'data' => $tindaklanjut
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->ip());
        $request->validate([
            'image' => 'required',
            'jenis' => 'required'
        ], [
            'image.required' => 'Image Wajib Ada!!!',
            'jenis.required' => 'Jenis Wajib di Isi!!!'
        ]);

        $input = $request->all();

        $pengaduan = pengaduan_masyarakat::where('ip', '=', $request->ip())->first();

        if ($imageData = $request->input('image')) {
            // Mendekode data URL
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = $request->name . "-" . date('YmdHis') . ".png";

            // Menyimpan gambar ke folder tujuan
            // $destinationPath = ('/home/suae7879/public_html/laporan/'); // Untuk Hosting
            $destinationPath = public_path('laporan/');
            file_put_contents($destinationPath . $imageName, base64_decode($image));

            // Menyimpan nama file gambar ke dalam input
            $input['image'] = $imageName;
        }

        $jarak = $this->haversineimplement($input['latitude'], $input['longitude']);

        // Ubah angka depan phone
        $phone = preg_replace('/^0/', '+62', $request['phone']);

        $petugas = $jarak->first();

        $today = Carbon::today();

        $ip = pengaduan_masyarakat::where('ip', $request->ip())
            ->whereDate('created_at', $today)
            ->count();

        if ($ip >= 2) {
            return redirect()->back()
                ->with('spam', 'This is an error message');
        } else {
            if ($petugas != null) {
                foreach ($petugas->pegawai as $pegawai) {
                    $email = $pegawai->email;

                    $pengaduan = pengaduan_masyarakat::create([
                        'name' => $input['name'],
                        'phone' => $phone,
                        'jenis' => $input['jenis'],
                        'image' => $input['image'],
                        'message' => $input['message'],
                        'detail' => $input['detail'],
                        'location' => $input['location'],
                        'latitude' => $input['latitude'],
                        'longitude' => $input['longitude'],
                        'id_pegawai' => $pegawai->id,
                        'status' => false,
                        'ip' => $request->ip()
                    ]);

                    $details = [
                        'title' => 'Pengaduan Masyarakat',
                        'subtitle' => $pegawai->name . ',',
                        'nama' => $input['name'],
                        'nohp' => $phone,
                        'message' => $input['message'],
                        'lokasi' => $input['location'],
                        'detail' => $input['detail'],
                        'id' => $pegawai->id,
                        'pengaduan' => $pengaduan->id,
                    ];

                    Mail::to($email)->send(new \App\Mail\Email($details));
                }

                // return response()->json($jarak);

                return redirect()->back()
                    ->with('success', 'Pengaduan berhasil dibuat')
                    ->with('petugas', $petugas)
                    ->with('jarak', $jarak);
            } else {
                pengaduan_masyarakat::create([
                    'name' => $input['name'],
                    'phone' => $phone,
                    'jenis' => $input['jenis'],
                    'image' => $input['image'],
                    'message' => $input['message'],
                    'detail' => $input['detail'],
                    'location' => $input['location'],
                    'latitude' => $input['latitude'],
                    'longitude' => $input['longitude'],
                    'status' => false,
                    'ip' => $request->ip()
                ]);

                return redirect()->back()
                    ->with('error', 'This is an error message');
            }
        }
    }


    public function haversineimplement($latitude, $longitude)
    {
        $today = Carbon::now()->toDateString();
        $jarak = lokasi::RangeFrom($latitude, $longitude)
            ->whereDate('updated_at', $today)
            ->with('pegawai')
            ->orderBy('jarak')
            ->get();
        return $jarak;
    }

    /**
     * Display the specified resource.
     */
    public function show(pengaduan_masyarakat $pengaduan_masyarakat)
    {
        $tindakan = tindak_lanjut::where('id_pengaduan', $pengaduan_masyarakat->id)->first();
        $pegawaiId = Auth::user()->id;
        // dd($pegawai);
        return view('landingPage.show', [
            'pengaduan_masyarakat' => $pengaduan_masyarakat,
            'tindakan' => $tindakan,
            'pegawaiId' => $pegawaiId,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pengaduan_masyarakat $pengaduan_masyarakat)
    {
        // dd($pengaduan_masyarakat->pegawai);

        $pegawais = User::orderBy('name')->get();;
        return view('landingPage.edit', compact('pengaduan_masyarakat', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pengaduan_masyarakat $pengaduan_masyarakat)
    {
        $input = $request->all();

        if ($input['id_pegawai'] == null) {
            $jarak = $this->haversineimplement($input['latitude'], $input['longitude'])->toArray();

            // dd($jarak);

            if (is_array($jarak) && !empty($jarak)) {
                foreach ($jarak as $pegawai) {
                    // Pastikan $pegawai->pegawai adalah array dan tidak kosong
                    if (isset($pegawai['pegawai']) && is_array($pegawai['pegawai']) && !empty($pegawai['pegawai'])) {
                        foreach ($pegawai['pegawai'] as $pg) {
                            $email = $pg['email'];

                            $pengaduan_masyarakat->update(['id_pegawai' => $pg['id']]);

                            $details = [
                                'title' => 'Pengaduan Masyarakat',
                                'subtitle' => $pg['name'] . ',',
                                'nama' => $input['name'],
                                'nohp' => $input['phone'],
                                'message' => $input['message'],
                                'lokasi' => $input['location'],
                                'detail' => $input['detail'],
                                'id' => $pg['id'],
                                'pengaduan' => $pengaduan_masyarakat->id,
                            ];

                            Mail::to($email)->send(new \App\Mail\Email($details));

                            return redirect()->route('pengaduan_masyarakat.index')
                                ->with('success', 'Petugas berhasil diperbarui');
                        }
                    }
                }
            } else {
                return redirect()->back()
                    ->with('error', 'Data jarak tidak valid atau kosong.');
            }
        } else {
            $pengaduan_masyarakat->update($input);

            foreach ($pengaduan_masyarakat->pegawai as $pegawai) {
                $email = $pegawai->email;

                $details = [
                    'title' => 'Pengaduan Masyarakat',
                    'subtitle' => $pegawai->name . ',',
                    'nama' => $pengaduan_masyarakat->name,
                    'nohp' => $pengaduan_masyarakat->phone,
                    'message' => $pengaduan_masyarakat->message,
                    'lokasi' => $pengaduan_masyarakat->location,
                    'detail' => $pengaduan_masyarakat->detail,
                    'id' => $pegawai->id,
                    'pengaduan' => $pengaduan_masyarakat->id,
                ];

                Mail::to($email)->send(new \App\Mail\Email($details));

                return redirect()->route('pengaduan_masyarakat.index')
                    ->with('success', 'Petugas berhasil diperbarui');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pengaduan_masyarakat $pengaduan_masyarakat)
    {
        $pengaduan_masyarakat->delete();

        return redirect()->route('pengaduan_masyarakat.index')
            ->with('success', 'Pengaduan masyarakat berhasil dihapus');
    }

    // public function cetak(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $query_data = pengaduan_masyarakat::with('pegawai')
    //             ->orderByRaw('YEAR(created_at), MONTH(created_at)')
    //             ->get();

    //         return DataTables::of($query_data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '
    //                     <div class="d-flex flex-column align-items-center">
    //                         <a class="btn btn-success show-btn" href="' . route('detail_tugas', $row->id) . '"> 
    //                             <i class="bx bx-printer"></i>
    //                         </a>
    //                     </div>';
    //                 return $btn;
    //             })
    //             ->addColumn('bulan', function ($row) {
    //                 return Carbon::parse($row->created_at)->format('F');
    //             })
    //             ->addColumn('tahun', function ($row) {
    //                 return Carbon::parse($row->created_at)->format('Y');
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('landingPage.cetak');
    // }

    function cetak()
    {
        $pengaduan_masyarakat = pengaduan_masyarakat::all();

        $pdf = Pdf::loadView('landingPage.pdf', [
            'pengaduan_masyarakat' => $pengaduan_masyarakat,
        ]);

        //Set Landscape
        // $pdf->setPaper('A4');

        // Untuk Download
        // return $pdf->download('LaporanProduct.pdf');

        // Nama File PDF
        return $pdf->stream('Laporan-Pengaduan.pdf');
    }
}
