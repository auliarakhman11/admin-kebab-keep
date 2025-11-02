<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersenPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'persen_pengeluaran';
    protected $fillable = ['cabang_id','akun_id','jenis','jumlah'];


    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class,'akun_id','id');
    }
}
