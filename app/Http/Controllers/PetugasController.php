<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $petugas = Petugas::create($data);
        return response()->json([
            'status' => true,
            'data' => $petugas
        ]);
    }
}
