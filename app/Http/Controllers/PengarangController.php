<?php

namespace App\Http\Controllers;

use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengarangController extends Controller
{

    public function index()
    {
        $pengarang = Pengarang::all();
        return response()->json([
            'status' => true,
            'data' => $pengarang
        ]);
    }

    public function show($id)
    {
        $pengarang = Pengarang::with('bukus')->find($id);
        return response()->json([
            'status' => true,
            'data' => $pengarang
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $pengarang = Pengarang::create($data);
        return response()->json([
            'status' => true,
            'data' => $pengarang
        ]);
    }
}
