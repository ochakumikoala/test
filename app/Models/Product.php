<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\ProductRequest;
use Validator;
use \InterventionImage;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;


class Product extends Model
{
    use SoftDeletes;
    use Sortable;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable =
        [
            'product_id',
            'company_id',
            'img_path',
            'product_name',
            'price',
            'stock',
            'comment',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    public $sortable = 
        [
            'product_id',
            'company_id',
            'img_path',
            'product_name',
            'price',
            'stock',
        ];

    //商品は会社に属するというリレーションの定義
    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id'); 
        //第一引数がproductsTableで指定しているcompany_id,第二引数がcompaniesTableで指定しているcompany_id
    }

    //productsテーブルから全てのデータを取得
    public function findAllProducts(){
        return Product::all();
    }

    //リクエストされたIDをもとにproductsテーブルのレコードを1件取得
    public function findProductById($id){
        return Product::find($id);
    }


    // 一覧表示の検索結果を返す
    public function getProducts($product_name, $company_id, $min_price, $max_price, $min_stock, $max_stock) {
        $query = Product::query()->with('company');
        
        if (!empty($product_name)) {
            $query->where('product_name', 'LIKE', '%' . $product_name . '%');
        }
        if (!empty($company_id)) {
            $query->where('company_id', $company_id);
        }
        if (!empty($min_price)) {
            $query->where('price', Product::min('price'), $min_price);
        }
        if (!empty($max_price)) {
            $query->where('price', Product::max('price'), $max_price);
        }
        if (!empty($min_stock)) {
            $query->where('stock', Product::min('stock'), $min_stock);
        }
        if (!empty($max_stock)) {
            $query->where('stock', Product::max('stock'), $max_stock);
        }
        
        $products = $query->sortable()->get();
        return $products;
    }

    //削除処理
    public function deleteById($id) {
        return $this->destroy($id);
    }

    //商品新規登録
    public function createProduct($request) {
        $inputs = $request->all();

        if($request->hasFile('img_path')){
            $file = $request->file('img_path');
            $name = $file->getClientOriginalName();
            InterventionImage::make($file)->resize(1080, 700)->save(public_path( 'storage/' . $name ));
        }else{
            $name = null;
        } 
        $inputs['img_path'] = $name;
        Product::create($inputs);
    }


    //更新処理
    public function updateProduct($request, $id) {
       if($request->hasFile('img_path')){
            $file_name = $request->file('img_path')->store('public');
        }else{
            $file_name = null;
        }        

        $product = Product::find($id);

        $product->company_id = $request->company_id;
        $product->img_path = $request->img_path;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->created_at = $request->created_at;
        
        if($file_name) {
            $product->img_path = $file_name;
        }

        $product->save();

    }
}