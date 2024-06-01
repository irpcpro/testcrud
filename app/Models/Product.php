<?php

namespace App\Models;

use App\Http\Controllers\Factories\Cache\CacheFactoryController;
use Illuminate\Support\Facades\Cache;
use MongoDB\Laravel\Relations\BelongsTo;

class Product extends ModelConfig {

    const CACH_EPREFIX_KEY = 'product_';

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'inventory',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function resolveRouteBinding($value, $field = null){
        $getProduct = CacheFactoryController::get($this::CACH_EPREFIX_KEY . $value);
        if($getProduct != null)
            return $getProduct;

        $getProduct = $this->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
        CacheFactoryController::set($this::CACH_EPREFIX_KEY . $value, $getProduct);
        return $getProduct;
    }

}
