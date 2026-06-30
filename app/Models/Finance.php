<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'transaction_type', 'amount', 'date', 'description'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relasi Finance belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Finance belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}