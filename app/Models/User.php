<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username', // Diganti dari 'name'
        'password',
        'role',     // Tambahkan kembali kolom 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime', // Tidak diperlukan
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One-to-One dengan model Dosen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    /**
     * Relasi One-to-One dengan model Mahasiswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }
}
