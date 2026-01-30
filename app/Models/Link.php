<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'is_active',
        'position',
        'icon_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits() {
        return $this->hasMany(LinkVisit::class);
    }
}
