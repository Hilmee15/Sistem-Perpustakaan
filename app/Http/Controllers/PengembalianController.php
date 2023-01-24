<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{

    public function index()
    {
        $pengembalian = Pengembalian::all();
        return response()->json([
            'status' => true,
            'data' => $pengembalian
        ]);
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::find($id);
        $peminjaman = Peminjaman::find($pengembalian->pengembalian_id);
        $anggota = Anggota::find($pengembalian->anggota_id);
        $petugas = Petugas::find($pengembalian->petugas_id);
        return response()->json([
            'status' => true,
            'data' => $pengembalian,
            'peminjaman' => $peminjaman->tanggal_pengembalian,
            'anggota' => $anggota->nama,
            'petugas' => $petugas->nama
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'denda' => 'required',
            'peminjaman_id' => 'required',
            'anggota_id' => 'required',
            'petugas_id' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $date = date('Y-m-d');

        $peminjaman = Peminjaman::find($data['peminjaman_id'])->update([
            'tanggal_kembali' => $date
        ]);
        if (!$peminjaman) {
            return response()->json([
                'status' => false,
                'message' => 'You have no Peminjaman'
            ], 404);
        }

        $anggota = Anggota::find($data['anggota_id']);
        if (!$anggota) {
            return response()->json([
                'status' => false,
                'message' => 'Anggota not found'
            ], 404);
        }

        $petugas = Petugas::find($data['petugas_id']);
        if (!$petugas) {
            return response()->json([
                'status' => false,
                'message' => 'Petugas not found'
            ], 404);
        }

        $pengembalian = Pengembalian::create([
            'tanggal_pengembalian' => $date,
            'denda' => $data['denda'],
            'peminjaman_id' => $data['peminjaman_id'],
            'anggota_id' => $data['anggota_id'],
            'petugas_id' => $data['petugas_id'],
        ]);

        return response()->json([
            'status' => true,
            'data' => $pengembalian
        ]);
    }
}
