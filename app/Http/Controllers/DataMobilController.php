<?php

namespace App\Http\Controllers;

use App\Models\MerekMobil;
use App\Models\Mobil;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DataMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data mobil beserta merek mobil yang terkait
        $mobil = Mobil::with('merekMobil')->get();
        // Mengambil semua data merek mobil
        $merekMobils = MerekMobil::all();

        return view('pages.admin.indexDataMobil', [
            'title' => 'Data Mobil',
            'mobil' => $mobil,
            'merekMobils' => $merekMobils
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
        try {
            // Validasi data yang diterima dari form
            $request->validate([
                'nama_mobil' => 'required|string|max:255',
                'id_merek' => 'required|integer',
                'plat' => 'required|string|max:255',
                'warna' => 'required|string|max:255',
                'tahun' => 'required',
            ]);

            // Simpan data mobil ke database
            Mobil::create([
                'nama_mobil' => $request->nama_mobil,
                'id_merek' => $request->id_merek,
                'plat' => $request->plat,
                'warna' => $request->warna,
                'tahun' => $request->tahun,
            ]);

            // Mengembalikan response dengan redirect dan pesan sukses
            return redirect()->back()->with('success', 'Mobil berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Mengembalikan response dengan redirect dan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
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
    public function edit($id)
    {
        try {
            $mobil = Mobil::findOrFail($id);
            return response()->json($mobil);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'id_merek' => 'required|integer',
            'plat' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'tahun' => 'required',
        ]);

        try {
            $mobil = Mobil::findOrFail($id);
            $mobil->update([
                'nama_mobil' => $request->nama_mobil,
                'id_merek' => $request->id_merek,
                'plat' => $request->plat,
                'warna' => $request->warna,
                'tahun' => $request->tahun,
            ]);

            return redirect()->back()->with('success', 'Mobil berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Cari data mobil berdasarkan $id
            $mobil = Mobil::findOrFail($id);

            // Hapus data mobil
            $mobil->delete();

            // Mengembalikan response dengan redirect dan pesan sukses
            return redirect()->back()->with('success', 'Mobil berhasil dihapus.');
        } catch (\Exception $e) {
            // Mengembalikan response dengan redirect dan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
