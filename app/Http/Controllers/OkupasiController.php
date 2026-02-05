<?php

namespace App\Http\Controllers;

use App\Models\DataOkupasi;
use Illuminate\Http\Request;

class OkupasiController extends Controller
{

    public function getOkupasi()
    {
        $data = DataOkupasi::latest()->get();

        return response()->json([
            'error' => false,
            'code'  => 200,
            'data'  => $data
        ]);
    }

    public function createOkupasi(Request $request)
    {
        $validated = $request->validate([
            'nama_okupasi' => 'required|string',
            'premi'        => 'required|numeric|min:0'
        ]);

        $data = DataOkupasi::create($validated);

        return response()->json([
            'error'   => false,
            'code'    => 201,
            'message' => 'Success create okupasi',
            'data'    => $data,
        ], 201);
    }

    public function updateOkupasi(Request $request, $id)
    {
        $okupasi = DataOkupasi::find($id);

        if (!$okupasi) {
            return response()->json([
                'error' => true,
                'message' => 'Data not found'
            ], 404);
        }

        $validated = $request->validate([
            'nama_okupasi' => 'nullable|string',
            'premi'        => 'nullable|numeric|min:0'
        ]);

        $okupasi->update($validated);

        return response()->json([
            'error'   => false,
            'code'    => 200,
            'message' => 'Success update okupasi',
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
