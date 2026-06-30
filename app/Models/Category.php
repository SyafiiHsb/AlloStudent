<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name'];

    // Relasi Category hasMany Finances
    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    // Relasi Category hasMany Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi Category hasMany Schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}