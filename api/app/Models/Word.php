<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    public const CATEGORY_GENERAL = 'general';
    public const CATEGORY_ARCHITECTURE = 'architecture';
    public const CATEGORY_CONSTRUCTION = 'construction';

    protected $fillable = ['word', 'phonetic', 'language', 'category', 'source_urls'];

    protected $casts = [
        'source_urls' => 'array',
    ];

    public function meanings(): HasMany
    {
        return $this->hasMany(Meaning::class);
    }
}
