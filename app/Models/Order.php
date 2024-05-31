<?php

namespace App\Models;


use Illuminate\Support\Collection;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\HasMany;

class Order extends ModelConfig {

    protected $fillable = [
        'user_id',
        'count',
        'total_price',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function orderProducts(): HasMany {
        return $this->hasMany(OrderProduct::class);
    }

    // Sync the data
    public function syncOrderProducts(Collection $data) {
        // add order_id & product_id to collection
        $data = $data->map(fn($item, $key) => [
            'order_id' => $this->id,
            'product_id' => $key,
            ...$item,
        ]);


        // TODO - remove
//        $data = collect([
//            "6657648a13e0daa072009d90" => [
//                "order_id" => "6658fe3ab4c31453c60c0822",
//                "product_id" => "6657648a13e0daa072009d90",
//                "count" => 8,
//                "price" => 52222
//            ]
//            , "6657648c13e0daa072009d92" => [
//                "order_id" => "6658fe3ab4c31453c60c0822",
//                "product_id" => "6657648c13e0daa072009d92",
//                "count" => 10,
//                "price" => 333444
//            ]
////            ,"6657648513e0daa072009d8c" => [
////                "order_id" => "6658fe3ab4c31453c60c0822",
////                "product_id" => "6657648513e0daa072009d8c",
////                "count" => 8,
////                "price" => 225
////            ]
////            ,"6658a3c9dd58a761eb0cc592" => [
////                "order_id" => "6658fe3ab4c31453c60c0822",
////                "product_id" => "6658a3c9dd58a761eb0cc592",
////                "count" => 8,
////                "price" => 225
////            ]
//        ]);

        // collect IDs to get orderProducts
        $orderIds = $data->pluck('order_id')->unique()->toArray();
//        $orderIds = ['6658fe3ab4c31453c60c0822']; // TODO - remove
        // get the OrderProducts
        $existingRecords = OrderProduct::whereIn('order_id', $orderIds)->get();

        // create if no data exists
        if($existingRecords->isEmpty()){
            $insertData = $data->values()->toArray();
            OrderProduct::insert($insertData);
            return $insertData;
        }else{
            // update existing data
            $bulkDeleteData = [];
            foreach ($existingRecords as $existingRecord) {
                $get = $data
                    ->where('order_id', $existingRecord->order_id)
                    ->where('product_id', $existingRecord->product_id)->first();

                if($get != null){
                    $existingRecord->update($get);
                    $data->forget($get['product_id']);
                }else{
                    $bulkDeleteData[] = $existingRecord->id;
                }
            }
            // delete existing in db which is not coming from data
            OrderProduct::destroy($bulkDeleteData);

            // insert new data
            OrderProduct::insert($data->values()->toArray());

            // return last data
            return $data;
        }
    }

}
