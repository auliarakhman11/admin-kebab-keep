<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunPengeluaran extends Model
{
    use HasFactory;
    protected $table = 'akun_pengeluaran';
    protected $fillable = ['nm_akun','jenis_akun_id','harga_gudang','jenis_pengeluaran','jumlah_pengeluaran'];

    public function jenisAkun()
    {
        return $this->belongsTo(JenisAkunPengeluaran::class,'jenis_akun_id','id');
    }

    public function persenPengeluaran()
    {
        return $this->hasMany(PersenPengeluaran::class,'akun_id','id');
    }

}
