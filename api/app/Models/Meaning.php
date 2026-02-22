<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meaning extends Model
{
    protected $fillable = ['word_id', 'part_of_speech', 'synonyms'];

    protected $casts = [
        'synonyms' => 'array',
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public function definitions(): HasMany
    {
        return $this->hasMany(Definition::class);
    }
}
