<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanDetailController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::all();

        $tanggal = array();
        $judul = array();

        foreach ($peminjaman as $p) {
            $tanggal[] = $p->tanggal_peminjaman;
            foreach ($p->bukus as $b) {
                $judul[] = $b->judul;
            }
        }

        return response()->json(
            [
                'status' => true,
                'tanggal_peminjaman' => $tanggal,
                'judul' => $judul
            ]
        );

        // return view('peminjaman_detail', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'peminjaman not found'
                ],
                404
            );
        }

        $tanggal = null;
        $judul = array();

        $tanggal = $peminjaman->tanggal_peminjaman;
        foreach ($peminjaman->bukus as $b) {
            $judul[] = $b->judul;
        }

        return response()->json(
            [
                'status' => true,
                'tanggal_peminjaman' => $tanggal,
                'judul' => $judul
            ]
        );
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $rules = [
            'peminjaman_id' => 'required',
            'buku_id' => 'required'
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

        $buku_ids = array();

       foreach ($input['buku_id'] as $value) {
        $buku = Buku::find($value);
        if (!$buku) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'buku not found'
                ],
                404
            );
        }else{
            $buku_ids[] = $value;
        }
       }

        $peminjaman = Peminjaman::find($input['peminjaman_id']);
        if (!$peminjaman) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'peminjaman not found'
                ],
                404
            );
        }

        $peminjaman->bukus()->attach($buku_ids);

        $data = DB::table('peminjaman_detail')->where('peminjaman_id', '=', $peminjaman->id)->get();

        return response()->json(
            [
                'status' => true,
                'data' => $data
            ]
        );
    }
}
