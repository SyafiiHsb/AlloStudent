<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'theme', // Tambahan untuk Settings
        'xp',    // Tambahan untuk Gamifikasi
        'level'  // Tambahan untuk Gamifikasi
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Keuangan
    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    // Relasi ke Tugas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi ke Jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}