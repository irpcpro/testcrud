<?php

namespace App\Models;

use MongoDB\Laravel\Relations\BelongsTo;

class Product extends ModelConfig {

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'inventory',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
