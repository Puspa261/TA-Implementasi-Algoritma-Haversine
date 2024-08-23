<?php

namespace App\Http\Controllers;

use App\Models\pengaduan_masyarakat;
use App\Models\tindak_lanjut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    function __construct()
    {

        $this->middleware(
            'permission:admin-list|user-list',
            ['only' => ['index']]
        );
    }

    public function all(Request $request)
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

        return view('dashboard.all');
    }

    public function ditanggapi(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('status', 1);

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

        return view('dashboard.ditanggapi');
    }

    public function belum_ditanggapi(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('status', 0);

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

        return view('dashboard.belumDitanggapi');
    }

    public function pkl(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('jenis', 'PK5');

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

        return view('dashboard.pkl');
    }

    public function gepeng(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('jenis', 'gepeng');

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

        return view('dashboard.gepeng');
    }

    public function pembangunan(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('jenis', 'pembangunan');

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

        return view('dashboard.pembangunan');
    }

    public function parkir(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('jenis', 'parkir');

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

        return view('dashboard.parkir');
    }

    public function kebisingan(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('jenis', 'kebisingan');

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

        return view('dashboard.kebisingan');
    }

    public function pg_all(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('id_pegawai', Auth::user()->id);

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

        return view('dashboard.pg-all');
    }

    public function pg_ditanggapi(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('status', 1)->where('id_pegawai', Auth::user()->id);

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

        return view('dashboard.pg-ditanggapi');
    }

    public function pg_belum_ditanggapi(Request $request)
    {
        if ($request->ajax()) {
            $query_data = pengaduan_masyarakat::with('pegawai')->where('status', 0)->where('id_pegawai', Auth::user()->id);

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

        return view('dashboard.pg-belumDitanggapi');
    }
}
