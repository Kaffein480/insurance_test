<?php

namespace App\Http\Controllers;

use App\Models\DataInvoice;
use App\Models\DataPolis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PolisController extends Controller
{

    private function generateNomorInvoice(): string
    {
        $lastInvoice = DataInvoice::orderBy('id', 'desc')->first();
        $nextNumber = 1;

        if ($lastInvoice && $lastInvoice->nomor_invoice) {
            $lastNumber = (int) substr($lastInvoice->nomor_invoice, -5);
            $nextNumber = $lastNumber + 1;
        }

        $runningNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return "K.001.$runningNumber";
    }

    private function generatedNomorPolis(): string
    {
        $lastInvoice = DataInvoice::orderBy('id', 'desc')->first();
        $nextNumber = 1;

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->nomor_invoice, -5);
            $nextNumber = $lastNumber + 1;
        }

        $runningNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return "K.01.001.$runningNumber";
    }


    public function getInvoice()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $invoices = DataInvoice::with('polis')->get();
        } else {
            $invoices = DataInvoice::with('polis')
                ->whereHas('polis', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        }

        return view('dashboard', compact('invoices'));
    }

    public function createPolis(Request $request)
    {
        $validated = $request->validate([
            'jenis_penanggungan' => 'required|string',
            'jangka_waktu'   => 'required|integer|min:1|max:10',
            'okupasi'        => 'required|string',
            'harga_bangunan' => 'required|numeric|min:0',
            'konstruksi'     => 'required|string',
            'alamat'         => 'required|string',
            'provinsi'       => 'required|string',
            'kota'           => 'required|string',
            'kabupaten'      => 'required|string',
            'daerah'         => 'required|string',
            'gempa'          => 'nullable|boolean',
            'premi'          => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $polis = DataPolis::create([
                'nomor_polis'      => 'Belum terbit',
                'jenis_penanggungan' => $validated['jenis_penanggungan'],
                'jangka_waktu'     => $validated['jangka_waktu'],
                'okupasi'          => $validated['okupasi'],
                'harga_bangunan'   => $validated['harga_bangunan'],
                'konstruksi'       => $validated['konstruksi'],
                'alamat'           => $validated['alamat'],
                'provinsi'         => $validated['provinsi'],
                'kota'             => $validated['kota'],
                'kabupaten'        => $validated['kabupaten'],
                'daerah'           => $validated['daerah'],
                'gempa'            => $request->boolean('gempa'),
                'user_id'          => Auth::id(),
            ]);

            $nomorInvoice = $this->generateNomorInvoice();

            $premiDasar = ($validated['harga_bangunan'] * $validated['premi'] / 1000)
                * $validated['jangka_waktu'];

            $totalBiaya = $premiDasar + 10000;

            $invoice = DataInvoice::create([
                'nomor_invoice' => $nomorInvoice,
                'polis_id'      => $polis->id,
                'jangka_waktu'  => $validated['jangka_waktu'],
                'premi_dasar'   => $premiDasar,
                'total_biaya'   => $totalBiaya,
                'status'        => 'pending'
            ]);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Success create polis & invoice',
                'data' => [
                    'polis' => $polis,
                    'invoice' => $invoice
                ]
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function findPolis($id)
    {
        $getData = DataPolis::find($id);

        if (!$getData) {
            return response()->json([
                'error' => true,
                'code' => 500,
                'message' => 'Data not found',
            ], 500);
        }

        return response()->json([
            'error' => false,
            'code' => 200,
            'data' => $getData
        ], 200);
    }
}
