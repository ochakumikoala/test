<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Company;



class company extends Model
{
    protected $table = 'companies';
    protected $fillable =
    [
        'company_name',
        'company_id',
    ];

    //メーカーと商品の関係は一対多（hasManyを使用する）
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
