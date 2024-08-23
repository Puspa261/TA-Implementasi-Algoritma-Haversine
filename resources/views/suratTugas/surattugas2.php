try {
        // Buat data untuk surat_tugas
        $suratTugasData = [
            'date' => $request->input('date'),
            'started_at' => $request->input('started_at'),
            'finished_at' => $request->input('finished_at'),
            'location' => $request->input('location'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ];

        // Insert data ke surat_tugas
        $suratTugas = surat_tugas::create($suratTugasData);

        // Dapatkan array id_user dan keterangan
        $idUsers = $request->input('id_user', []);
        $keteranganItems = $request->input('keterangan', []);

        // Variabel untuk melacak indeks keterangan
        $keteranganIndex = 0;
        $keteranganCount = count($keteranganItems);

        foreach ($idUsers as $userId) {
            // Gunakan keterangan yang sesuai
            $keterangan = $keteranganItems[$keteranganIndex] ?? 'No description';

            // Buat entri Detail
            Detail::create([
                'id_user' => $userId,
                'id_surat_tugas' => $suratTugas->id,
                'keterangan' => $keterangan,
            ]);

            // Jika masih ada keterangan yang tersisa, perbarui indeks keterangan
            if ($keteranganIndex < $keteranganCount - 1) {
                $keteranganIndex++;
            }
        }

        return response()->json(['message' => 'Success'], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }