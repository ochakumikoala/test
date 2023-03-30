<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'ver';
    protected $dates =  ['created_at', 'updated_at'];
    protected $fillable = ['stock']; //編集していい値

    //減算処理
    public function decrementStock($product){
        $check_stock = Product::where('id', $product->product_id)->first()->stock_quantity;

        if ($check_stock > 0 && $check_stock >= $product->quantity) {
            $stock = Product::where('id', $product->product_id)->decrement('stock_quantity', $product->quantity);
        }else{
            //session()->flash(config('const.err_log.err_msg'));
            throw new Exception();
            return redirect(route('products'));
        }
    }
    
}
