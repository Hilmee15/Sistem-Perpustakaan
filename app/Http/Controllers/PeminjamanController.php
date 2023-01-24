<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all();
        return response()->json(
            [
                'status' => true,
                'data' => $peminjaman
            ]
        );
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::find($id);
        $anggota = Anggota::find($peminjaman->anggota_id);
        $petugas = petugas::find($peminjaman->petugas_id);
        return response()->json(
            [
                'status' => true,
                'data' => $peminjaman,
                'anggota' => $anggota->nama,
                'petugas' => $petugas->nama
            ]
        );
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $rules = [
            'anggota_id' => 'required',
            'petugas_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $anggota = Anggota::find($input['anggota_id']);
        if (!$anggota) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'anggota not found'
                ],
                404
            );
        }

        $petugas = Petugas::find($input['petugas_id']);
        if (!$petugas) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'petugas not found'
                ],
                404
            );
        }

        $date = date('Y-m-d');

        $peminjaman = Peminjaman::create(
            [
                'tanggal_peminjaman' => $date,
                'anggota_id' => $input['anggota_id'],
                'petugas_id' => $input['petugas_id']

            ]
        );
        return response()->json(
            [
                'status' => true,
                'data' => $peminjaman
            ]
        );
    }
}
