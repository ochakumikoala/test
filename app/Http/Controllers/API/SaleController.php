<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class SaleController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $product_name = $request->input( 'product_name' );
        $company_id = $request->input( 'company_name' );
        $max_price = $request->input('max_price');
        $min_price = $request->input('min_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');

        $products = $this->product
            ->getProducts($product_name, $company_id, $max_price, $min_price, $min_stock, $max_stock);
        
        $product_list = $products->map(function(Product $product){
            $product['img_path'] = Storage::url($product->img_path);
            $product['detail'] = route('detail', ['id' => $product->product_id]);
            $product['delete'] = route('delete', $product->product_id);
            return $product;
        });

        return response()->json($products, Response::HTTP_OK);
    }
    
    //削除処理
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect(route('products'));
    }

}

