<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = ['user_id', 'nama', 'nidn', 'kaprodi', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getFotoUrlAttribute()
{
    return $this->foto ? asset('assets/img/dosen/' . $this->foto) : asset('assets/img/dosen/default.png');
}

}