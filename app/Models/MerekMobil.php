<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mobil;

class MerekMobil extends Model
{
    use HasFactory;
    //table name
    protected $table = 'merek_mobil';
    //primary key
    protected $primaryKey = 'id';
    //field yang bisa di isi
    protected $fillable = ['nama_merek'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'id_merk');
    }
}
