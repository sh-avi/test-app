<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    public function blogpost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }
}
