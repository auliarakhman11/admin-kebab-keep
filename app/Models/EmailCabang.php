<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCabang extends Model
{
    use HasFactory;
    
    protected $table = 'email_cabang';
    protected $fillable = ['cabang_id','email','password','ket'];

}
