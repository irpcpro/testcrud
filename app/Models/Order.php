<?php

namespace App\Models;


use App\Enums\ProductInventoryActionEnum;
use App\Http\Controllers\Factories\Product\ProductFactoryController;
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


    private function decreaseProductInventory($data){
        foreach ($data as $item)
//            dd($item['product']);
            ProductFactoryController::updateInventory($item['product'], $item['count'], ProductInventoryActionEnum::DECREASE);
    }

    private function updateProductInventory($data, OrderProduct $orderProduct){
        if($data['count'] > $orderProduct->count){
            ProductFactoryController::updateInventory($data['product'], ($data['count'] - $orderProduct->count), ProductInventoryActionEnum::DECREASE);
        }elseif($data['count'] < $orderProduct->count){
            ProductFactoryController::updateInventory($data['product'], ($orderProduct->count - $data['count']), ProductInventoryActionEnum::INCREASE);
        }
    }

    // delete existing in db which is not coming from data
    private function deleteExistingOrderProduct($existingOrderProducts){
        // increase the inventory of products
        foreach ($existingOrderProducts as $item)
            ProductFactoryController::updateInventory($item->product, $item->count, ProductInventoryActionEnum::INCREASE);

        // remove all order products
        OrderProduct::destroy($existingOrderProducts->pluck('id'));
    }

    private function insertOrderProducts($data){
        $insertData = $data->values()->toArray();
        OrderProduct::insert($insertData);
        $this->decreaseProductInventory($data);
    }

    // Sync the data
    public function syncOrderProducts(Collection $data){
        // add order_id & product_id to collection
        $data = $data->map(fn($item, $key) => [
            'order_id' => $this->id,
            'product_id' => $key,
            ...$item,
        ]);


        // TODO - remove
        $data = collect([
//            "66573ebc263338de33071837" => ["order_id" => "665ad757263338de330718cb", "product_id" => "66573ebc263338de33071837", "count" => 5, "price" => 100, 'product' => Product::where('_id', '66573ebc263338de33071837')->first()],
//             "66573f9d263338de33071838" => ["order_id" => "665ad757263338de330718cb", "product_id" => "66573f9d263338de33071838", "count" => 5, "price" => 200, 'product' => Product::where('_id', '66573f9d263338de33071838')->first()],
//            "66573fd6263338de33071839" => ["order_id" => "665ad757263338de330718cb", "product_id" => "66573fd6263338de33071839", "count" => 5, "price" => 300, 'product' => Product::where('_id', '66573fd6263338de33071839')->first()],
//            "66573fe9263338de3307183a" => ["order_id" => "665ad757263338de330718cb", "product_id" => "66573fe9263338de3307183a", "count" => 5, "price" => 400, 'product' => Product::where('_id', '66573fe9263338de3307183a')->first()],
        ]);

        // collect IDs to get orderProducts
//        $orderIds = $data->pluck('order_id')->unique()->toArray();
        $orderIds = '665ad757263338de330718cb'; // TODO - remove
        // get the OrderProducts
//        $existingRecords = OrderProduct::where('order_id', $this->id)->get();
        $existingRecords = OrderProduct::where('order_id', $this->id)->get();


        // create if no data exists
        if($existingRecords->isEmpty()){

//            $insertData = $data->values()->toArray();
//            OrderProduct::insert($insertData);
//            $this->decreaseProductInventory($data);
            $this->insertOrderProducts($data);

            return $data;
        }else{
            // update existing data
            $bulkDeleteData = collect([]);
            foreach ($existingRecords as $existingRecord) {
                $get = $data
                    ->where('order_id', $existingRecord->order_id)
                    ->where('product_id', $existingRecord->product_id)->first();

                if($get != null){
                    $this->updateProductInventory($get, $existingRecord);
                    $existingRecord->update($get);
                    $data->forget($get['product_id']);
                }else{
                    $bulkDeleteData[] = $existingRecord;
                }
            }

            // delete existing in db which is not coming from data
            if(!empty($bulkDeleteData))
                $this->deleteExistingOrderProduct($bulkDeleteData);

            // insert new data
            if(!empty($data)){

//                dd('here', $data);
//                OrderProduct::insert($data->values()->toArray());
                $this->insertOrderProducts($data);
            }

            // return last data
            return $data;
        }
    }

}
