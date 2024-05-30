<?php

namespace App\Models;


use Illuminate\Support\Collection;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;

class Order extends ModelConfig {

    protected $fillable = [
        'user_id',
        'count',
        'total_price',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


//    public function products()
//    {
//        return $this->belongsToMany(Product::class, null, 'order_ids', 'product_ids')
//            ->withPivot('count', 'price')
//            ->withTimestamps();
//    }

//    public function orderProduct(): BelongsToMany {
//        return $this->belongsToMany(OrderProduct::class)->withPivot('count', 'price');
//    }

//    public function products(): BelongsToMany {
//        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
//            ->withPivot('count', 'price');
//    }


    /*  */
    public function orderProducts(Collection $data){
        // add order_id & product_id to collection
//        $data = $data->map(fn($item, $key) => [
//            'order_id' => $this->id,
//            'product_id' => $key,
//            ...$item
//        ]);
//        $orderIds = $data->pluck('order_id')->unique()->toArray();
//        $productIds = $data->pluck('product_id')->unique()->toArray();
//
//        dd($orderIds, $productIds);
//
//        $existingRecords = OrderProduct::whereIn('order_id', $orderIds)->whereIn('product_id', $productIds)->get();
//
//        dd($existingRecords);
//
//        if(!$existingRecords->exists())
//            OrderProduct::insert($data->values()->toArray());


//        Order::all()->map(fn($item)=>$item->delete()); dd(2);

    }

}
