<?php

namespace App\Models;

use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;

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

//    public function orders()
//    {
//        return $this->belongsToMany(Order::class, null, 'product_ids', 'order_ids')
//            ->withPivot('count', 'price')
//            ->withTimestamps();
//    }


//    public function orders(): BelongsToMany {
//        return $this->belongsToMany(Order::class, 'order_product')
//            ->withPivot('count', 'price')
//            ->withTimestamps();
//    }

//    public function orders()
//    {
//        return $this->belongsToMany(Order::class, 'order_products')
//            ->withPivot('count', 'price');
//    }

}
