<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use \InterventionImage;
use Illuminate\View\View;

class SaleController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $products = Product::query();
        $product_name = $request->input('product_name');
        $company_id = $request->input('company_name');
        $max_price = $request->input('max_price');
        $min_price = $request->input('min_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');

        $products = $this->product
            ->getProducts($product_name, $company_id, $max_price, $min_price, $min_stock, $max_stock);
        
        foreach($products as $key => $value){
            $value->img_path = Storage::url($value->img_path);
            $value->detail = route('detail', ['id' => $value->product_id]);
            $value->delete = route('delete', $value->product_id);
        }

        foreach($products as $product) {
            $product->company_name = $product->company->company_name;
        }

        return response()->json(['products' => $products,
        'product_name' => $product_name,
        'company_name' => $company_id,
        'max_price' => $max_price,
        'min_price' => $min_price,
        'min_stock' => $min_stock,
        'max_stock' => $max_stock,
    ]);
    }
    
    //削除処理
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect(route('products'));
    }

}

