<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Clothes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'photo'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function looks(): BelongsToMany
    {
        return $this->belongsToMany(Look::class);
    }

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class);
    }
}
