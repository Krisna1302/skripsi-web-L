<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'mahasiswa';
    protected $fillable = ['user_id', 'nama', 'nim', 'prodi', 'foto'];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'mahasiswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
// app/Models/Mahasiswa.php
public function getFotoUrlAttribute()
{
    $path = public_path('assets/img/mahasiswa/' . $this->foto);
    if ($this->foto && file_exists($path)) {
        return asset('assets/img/mahasiswa/' . $this->foto);
    }
    return asset('assets/img/mahasiswa/default.png');
}
}
