  // $request->validate([
        //     'id_user.*' => 'required',
        //     'location' => 'required',
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        // ], [
        //     'id_user.*.required' => 'Pegawai harus dipilih',
        //     'location.required' => 'Lokasi Wajib di Isi',
        //     'latitude.required' => 'Latitude Wajib di Isi',
        //     'longitude.required' => 'Longitude Wajib di Isi',
        // ]);


        // try {
            
        // $input = $request->all();
        // // dd($input);
        // $suratTugasData = [
        //     'date' => $request->input('date'),
        //     'started_at' => $request->input('started_at'),
        //     'finished_at' => $request->input('finished_at'),
        //     'location' => $request->input('location'),
        //     'latitude' => $request->input('latitude'),
        //     'longitude' => $request->input('longitude'),
        // ];
        
        // $suratTugas = surat_tugas::create($suratTugasData);
        
        // $idUsers = $request->input('id_user');
        // foreach ($idUsers as $userId) {
        //     Detail::create([
        //         'id_user' => $userId,
        //         'id_surat_tugas' => $suratTugas->id,
        //         'keterangan' => 
        //     ]);
        // }
        // return response()->json(['message'=>'success'],200);
        // } catch (\Exception $e) {
        //     //throw $th;
        // return response()->json(['message'=>$e->getMessage()],500);

        // }

        // $user_ids = $input['id_user1'];

        // dd($user_ids);

        

        // $ket = $input['keterangan'];
        // $surat_tugas = surat_tugas::create($input);
        
     
        // $str0 = ''; // Inisialisasi dengan string kosong

        // foreach($ket as $ke){
        //     $model = new Detail();
        //     $model->id_surat_tugas = $surat_tugas->id;
        //     $model->keterangan = $ke;
            
        //     $str = 'id_user'.$str0;
        //     $user = $input[$str];

            
        //     if (is_array($user)) {
        //         // Lakukan sesuatu untuk menangani array, misalnya, ubah menjadi string atau loop melalui elemen-elemen array
        //         $userAsString = implode(',', $user); // Ubah array menjadi string
        //         $model->id_user = $userAsString; // Setel properti id_user dengan string yang diperoleh dari array
        //     } else {
        //         $model->id_user = $user; // Setel properti id_user dengan nilai string langsung jika bukan array
        //     }

        //     $model->save();

        //     if ($str0 === '') {
        //         $str0 = 1; // Ubah nilai $str0 menjadi 1 setelah penggunaan string kosong
        //     } else {
        //         $str0++; // Tambahkan nilai $str0 setelah setiap iterasi
        //     }
          
        // }

        
        

        

        // $data = [
        //     'id_user' => $user_ids,
        //     'ket' => $ket
        // ];
        
        // if (count($data['ket']) < count($data['id_user']) + 1) {
        //     // Duplikat keterangan index 0 ke index 1 jika jumlah elemen kurang
        //     $data['ket'][] = $data['ket'][0];

        //     array_splice($data['ket'], 1, 0, $data['ket'][0]);
        // }
        
        // Loop untuk memasukkan data ke dalam database
        // foreach ($data['id_user'] as $key => $userId) {
        //     $model = new Detail();
        //     $model->id_surat_tugas = $surat_tugas->id; // Pastikan $surat_tugas->id sudah terdefinisi sebelumnya
        //     $model->id_user = $userId;

        //     dd($data['ket']);
        
        //     // Menentukan keterangan berdasarkan user_id
        //     $model->keterangan = isset($data['ket'][$key]) ? $data['ket'][$key] : $ket[0];
        
        //     $model->save();
        // }

        // return redirect()->route('surat_tugas.index')
        //     ->with('success', 'Surat Tugas berhasil dibuat');

        // Validasi input
       // Validasi input