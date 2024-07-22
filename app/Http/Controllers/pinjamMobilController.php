<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class pinjamMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobil = Mobil::with(['merekMobil', 'peminjaman'])
            ->leftJoin('peminjaman', function ($join) {
                $join->on('mobil.id', '=', 'peminjaman.id_mobil')
                    ->whereIn('peminjaman.status', ['pinjam', 'tersedia']);
            })
            ->select('mobil.*', 'peminjaman.status', 'peminjaman.tgl_mulai', 'peminjaman.tgl_kembali')
            ->get();

        // Debugging purpose
        // dd($mobil);

        return view('pages.pinjam.index', [
            'title' => 'Pinjam Mobil',
            'mobil' => $mobil
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
        // Validasi input
        $request->validate([
            'namaMobil' => 'required|string|max:255',
            'plat' => 'required|string|max:255',
            'tglMulai' => 'required|date',
            'tglSelesai' => 'required|date|after_or_equal:tglMulai',
        ]);

        // Cari mobil berdasarkan nama dan plat
        $mobil = Mobil::where('nama_mobil', $request->namaMobil)
            ->where('plat', $request->plat)
            ->first();

        if ($mobil) {
            // Simpan data peminjaman
            Pinjam::create([
                'id_mobil' => $mobil->id,
                'id_user' => auth()->id(), // Asumsi user sudah login
                'tgl_mulai' => $request->tglMulai,
                'tgl_kembali' => $request->tglSelesai,
                'status' => 'pending',
            ]);

            return redirect()->route('pinjam.index')->with('success', 'Data pinjam berhasil dikirim, mohon menunggu konfirmasi dari atasan');
        } else {
            return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(pinjam $pinjam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pinjam $pinjam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pinjam $pinjam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pinjam = Pinjam::findOrFail($id);
            $pinjam->delete();

            return response()->json(['message' => 'Peminjaman berhasil dibatalkan.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting pinjam: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat membatalkan peminjaman.'], 500);
        }
    }
}
