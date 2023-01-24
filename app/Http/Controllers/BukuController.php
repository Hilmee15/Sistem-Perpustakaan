<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return response()->json([
            'status' => true,
            'data' => $buku
        ]);
    }

    public function show($id)
    {
        $buku = Buku::find($id);
        $penerbit = Penerbit::find($buku->penerbit_id);
        $pengarang = Pengarang::find($buku->pengarang_id);
        $rak = Rak::find($buku->rak_id);
        return response()->json([
            'status' => true,
            'data' => $buku,
            'penerbit' => $penerbit->nama,
            'pengarang' => $pengarang->nama,
            'rak' => $rak->kode_rak,
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'judul' => 'required',
            'tahun_terbit' => 'required',
            'jumlah' => 'required',
            'isbn' => 'required',
            'pengarang_id' => 'required',
            'penerbit_id' => 'required',
            'rak_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $pengarang = Pengarang::find($data['pengarang_id']);
        if (!$pengarang) {
            return response()->json([
                'status' => false,
                'message' => 'Pengarang not found'
            ], 404);
        }

        $penerbit = Penerbit::find($data['penerbit_id']);
        if (!$penerbit) {
            return response()->json([
                'status' => false,
                'message' => 'Penerbit not found'
            ], 404);
        }

        $rak = Rak::find($data['rak_id']);
        if (!$rak) {
            return response()->json([
                'status' => false,
                'message' => 'Kode Rak not found'
            ], 404);
        }

        $buku = Buku::create($data);


        return response()->json([
            'status' => true,
            'data' => $buku
        ]);
    }
}
