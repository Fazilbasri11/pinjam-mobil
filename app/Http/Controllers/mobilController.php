<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class mobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil id user yang sedang login
        $userId = auth()->id();
        // Query data peminjaman yang dilakukan oleh user yang sedang login
        $mobil = Pinjam::with('mobil.merekMobil')
            ->where('id_user', $userId)
            ->where(function ($query) {
                $query->where('status', 'pinjam')
                    ->orWhere('status', 'pending');
            })
            ->get();
        $riwayats = Pinjam::with(['mobil.merekMobil'])
            ->where('id_user', $userId)
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

        return view('pages.mobil.index', [
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
    public function show(mobil $mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(mobil $mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Ambil pinjaman berdasarkan ID
        $pinjam = Pinjam::findOrFail($id);

        // Ubah status menjadi 'selesai'
        $pinjam->status = 'selesai';
        $pinjam->tgl_kembali = now();
        $pinjam->save();

        // Redirect atau response sesuai kebutuhan aplikasi Anda
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil dikembalikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
