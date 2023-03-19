<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'ver';
    protected $dates =  ['created_at', 'updated_at'];
    protected $fillable = ['stock']; //編集していい値

    public function decrementStock($id){
        $product = Product::find($id);
        $product->decrement('stock');
        return redirect(route('products'));
   
        DB::transaction(function () {
            if('stock' < 0){
                throw new Exception('在庫がありません');
            }
        });
    }
}
