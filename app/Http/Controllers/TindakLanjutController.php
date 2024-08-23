<?php

namespace App\Http\Controllers;

use App\Models\pengaduan_masyarakat;
use App\Models\tindak_lanjut;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    function __construct()
    {

        $this->middleware(
            'permission:user-create',
            ['only' => ['store']]
        );
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $pengaduan = pengaduan_masyarakat::find($id);
        // dd($pengaduan->name);
        return view('tindakLanjut.create', compact('pengaduan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {

        $pengaduan = pengaduan_masyarakat::find($id);

        $request->validate([
            'image' => 'required',
        ]);

        if ($imageData = $request['image']) {
            // Mendekode data URL
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = "TL-" . $pengaduan->name . "-" . date('YmdHis') . ".png";

            // Menyimpan gambar ke folder tujuan
            // $destinationPath = ('/home/suae7879/public_html/tindak_lanjut/');
            $destinationPath = public_path('tindak_lanjut/');
            file_put_contents($destinationPath . $imageName, base64_decode($image));

            // Menyimpan nama file gambar ke dalam input
            $request['image'] = $imageName;
        }

        tindak_lanjut::create([
            'id' => $id,
            'id_pengaduan' => $pengaduan->id,
            'image' => $request['image'],
            'detail' => $request['detail'],
        ]);

        $pengaduan->update([
            'status' => true,
        ]);

        return redirect()->route('pengaduan_masyarakat.show', $pengaduan->id)
            ->with('success', 'Pengaduan berhasil ditanggapi');
    }

    /**
     * Display the specified resource.
     */
    public function show(tindak_lanjut $tindak_lanjut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tindak_lanjut $tindak_lanjut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tindak_lanjut $tindak_lanjut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tindak_lanjut $tindak_lanjut)
    {
        //
    }
}
