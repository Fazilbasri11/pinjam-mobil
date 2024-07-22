<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MerekMobil;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_mobil', 'id_merek', 'plat', 'warna', 'tahun'];

    public function merekMobil()
    {
        return $this->belongsTo(MerekMobil::class, 'id_merek')->withDefault(['nama_merek' => 'Nama Merek Default']);
    }

    public function peminjaman()
    {
        return $this->hasOne(Pinjam::class, 'id_mobil');
    }
}
