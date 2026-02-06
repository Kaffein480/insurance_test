<?php

namespace App\Http\Controllers;

use App\Models\DataOkupasi;
use Illuminate\Http\Request;

class OkupasiController extends Controller
{

    public function getOkupasi()
    {
        $okupasi = DataOkupasi::all();

        return response()->json([
            'error' => false,
            'code'  => 200,
            'data'  => $okupasi
        ]);
    }

    public function findOkupasi($id)
    {
        $okupasi = DataOkupasi::find($id);

        return view('okupasi.update', compact('okupasi'));
    }

    public function createOkupasi(Request $request)
    {
        $validated = $request->validate([
            'nama_okupasi' => 'required|string',
            'premi'        => 'required|numeric|min:0'
        ]);

        $data = DataOkupasi::create($validated);

        if (!$data) {
            return response()->json([
                'error'   => true,
                'code'    => 500,
                'message' => 'Failed to create okupasi'
            ], 500);
        }

        return response()->json([
            'error'   => false,
            'code'    => 201,
            'message' => 'Success create okupasi',
            'data'    => $data,
        ], 201);
    }

    public function updateOkupasi(Request $request, $id)
    {

        $validated = $request->validate([
            'nama_okupasi' => 'nullable|string',
            'premi'        => 'nullable|numeric|min:0'
        ]);


        $okupasi = DataOkupasi::find($id);

        if (!$okupasi) {
            return response()->json([
                'error' => true,
                'message' => 'data not found'
            ], 404);
        }

        $exist = DataOkupasi::find($request->nama_okupasi);
        if ($exist) {
            return response()->json([
                'error' => true,
                'message' => ' okupasi name already existed'
            ], 404);
        }


        $okupasi->update($validated);

        return response()->json([
            'error'   => false,
            'code'    => 200,
            'message' => 'success update okupasi',
            'data'    => $okupasi
        ]);
    }


    public function deleteOkupasi($id)
    {
        $okupasi = DataOkupasi::find($id);

        if (!$okupasi) {
            return response()->json([
                'error' => true,
                'message' => 'Data not found'
            ], 404);
        }

        $okupasi->delete();

        return response()->json([
            'error'   => false,
            'code'    => 200,
            'message' => 'Data successfully deleted'
        ]);
    }
}
