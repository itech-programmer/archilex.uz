<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Definition extends Model
{
    protected $fillable = ['meaning_id', 'definition', 'example'];

    public function meaning(): BelongsTo
    {
        return $this->belongsTo(Meaning::class);
    }
}
