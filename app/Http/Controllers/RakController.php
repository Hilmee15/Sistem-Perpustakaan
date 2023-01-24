<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RakController extends Controller
{

    public function index()
    {
        $rak = Rak::all();
        return response()->json([
            'status' => true,
            'data' => $rak
        ]);
    }

    public function show($id)
    {
        $rak = Rak::with('bukus')->find($id);
        return response()->json([
            'status' => true,
            'data' => $rak
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'kode_rak' => 'required',
            'lokasi' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $rak = Rak::create($data);
        return response()->json([
            'status' => true,
            'data' => $rak
        ]);
    }
}
