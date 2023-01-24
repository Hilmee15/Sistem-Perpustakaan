<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianDetailController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::all();

        $tanggal = array();
        $judul = array();

        foreach ($pengembalian as $p) {
            $tanggal[] = $p->tanggal_pengembalian;
            foreach ($p->bukus as $b) {
                $judul[] = $b->judul;
            }
        }

        return response()->json(
            [
                'status' => true,
                'tanggal_pengembalian' => $tanggal,
                'judul' => $judul
            ]
        );

        // return view('peminjaman_detail', compact('peminjaman'));
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::find($id);
        if (!$pengembalian) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'pengembalian not found'
                ],
                404
            );
        }

        $tanggal_kembali = null;
        $judul_kembali = array();

        $tanggal_kembali = $pengembalian->tanggal_pengembalian;
        foreach ($pengembalian->bukus as $b) {
            $judul_kembali[] = $b->judul;
        }

        $peminjaman = Peminjaman::find($pengembalian->peminjaman_id);

        $tanggal_pinjam = null;
        $judul_pinjam = array();

        $tanggal_pinjam = $peminjaman->tanggal_peminjaman;
        foreach ($pengembalian->bukus as $b) {
            $judul_pinjam[] = $b->judul;
        }

        return response()->json(
            [
                'status' => true,

                'tanggal_kembali' => $tanggal_kembali,
                'judul_kembali' => $judul_kembali,
                'tanggal_pinjam' => $tanggal_pinjam,
                'judul_pinjam' => $judul_pinjam,
            ]
        );
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $rules = [
            'pengembalian_id' => 'required',
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

       $pengembalian = Pengembalian::find($input['pengembalian_id']);
        if (!$pengembalian) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'pengembalian not found'
                ],
                404
            );
        }

        $pengembalian->bukus()->attach($buku_ids);

        $data = DB::table('pengembalian_detail')->where('pengembalian_id', '=', $pengembalian->id)->get();

        return response()->json(
            [
                'status' => true,
                'data' => $data
            ]
        );
    }
}
