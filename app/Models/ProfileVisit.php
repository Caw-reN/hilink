<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVisit extends Model
{
    use HasFactory;

    // --- TAMBAHKAN BAGIAN INI ---
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];
    // ----------------------------

    // Opsional: Tambahkan relasi ke user (biar lengkap)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}