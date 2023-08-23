<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Style extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function clothes(): BelongsToMany
    {
        return $this->belongsToMany(Clothes::class);
    }
}
