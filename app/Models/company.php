<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;



class company extends Model
{
    protected $table = 'companies';
    protected $fillable =
    [
        'company_name',
        'company_id',
    ];

    //メーカーはたくさんの商品を持つというリレーションの定義
    public function products(){
        return $this->hasMany( Product::class );
    }

    //商品の新規登録をする際にcompany_idを１つ取ってくる処理
    public function findById($id){
        return self::query()
        ->where( 'company_id', $id)->first();
    }

    //companyの情報を全て取ってくる処理
    public function getAll(){
        return self::all();
    }
    
}
