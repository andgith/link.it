<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    /** @use HasFactory<\Database\Factories\DomainFactory> */
    use HasFactory;

    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * Get the links for the domain.
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Scope a query to only include the default domain.
     */
    public function scopeDefault(Builder $query): void
    {
        $query->where('default', true);
    }
}
