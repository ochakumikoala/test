<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\ProductRequest;
use Validator;
use \InterventionImage;
use App\Models\Company;


class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable =
    [
        'imgPath',
        'productName',
        'companyName',
        'comment',
        'price',
        'stock'
    ];

    //メーカーと商品の関係は多対一（belongsToを使用する）
    public function company(){
        return $this->belongsTo( Company::class );
    }

    // 条件に一致するProduct(this)の一覧を返却する
    public function getProducts($productName, $companyId) {
        return self::query()
        ->leftJoin('companies', 'products.companyName', '=', 'companies.companyName')
        ->when(!is_null($productName), function (Builder $query) use ($productName) {
            $query->where('products.productName', 'LIKE', "%$productName%");
        })
        ->when(!is_null($companyId), function (Builder $query) use ($companyId) {
            $query->orWhere('companies.company_id', $companyId);
        })
        ->get();
    }


      //商品新規登録
      public function createProduct($inputs){
        Self::create($inputs);
      }

      //削除処理
      public function deleteById($id){
        Self::destroy($id);
      }
      
      //商品のIDを取ってくる
      public function findById($id){
        return Self::find($id);
      }

      //更新処理
      public function updateProduct($inputs){
        $this->findById($inputs['id'])->fill($inputs)->save();
      }
}

