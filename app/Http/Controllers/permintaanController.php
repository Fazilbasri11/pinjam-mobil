<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjam;

class permintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query data peminjaman yang masih dalam status pinjam atau pending
        $mobil = Pinjam::with('mobil.merekMobil')
            ->where(function ($query) {
                $query->where('status', 'pinjam')
                    ->orWhere('status', 'pending');
            })
            ->get();

        // Query data riwayat peminjaman yang sudah selesai
        $riwayats = Pinjam::with(['mobil.merekMobil'])
            ->where('status', 'selesai')
            ->whereHas('mobil', function ($query) {
                $query->whereNotNull('id')
                    ->whereNotNull('nama_mobil')
                    ->whereNotNull('id_merek')
                    ->whereNotNull('plat')
                    ->whereNotNull('warna')
                    ->whereNotNull('tahun');
            })
            ->get();

        return view('pages.admin.permintaan', [
            'title' => 'Data Pinjaman Mobil',
            'mobil' => $mobil,
            'riwayats' => $riwayats
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $pinjam = Pinjam::findOrFail($id);
            $pinjam->update(['status' => $request->status]);

            return response()->json(['message' => 'Status berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui status.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
