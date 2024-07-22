<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;
    //table name
    protected $table = 'peminjaman';
    //primary key
    protected $primaryKey = 'id';
    //field yang bisa di isi
    protected $fillable = ['id_mobil', 'id_user', 'tgl_mulai', 'tgl_kembali', 'status'];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
