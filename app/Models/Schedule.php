<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'day', 'start_time', 'end_time', 'subject_name', 'room'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relasi Schedule belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Schedule belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}