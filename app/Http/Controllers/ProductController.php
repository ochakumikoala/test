<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Validator;
use \InterventionImage;


class ProductController extends Controller
{

    /**
     * 商品一覧を表示する
     *
     * @return view
     */

    public function productList(Request $request) {
        $companies = Company::all();

        $productName = $request->input( 'productName' );
        $companyId = $request->input( 'company_id' );

        $query =  Product::query();

        $query->leftJoin('companies', 'products.companyName', '=', 'companies.companyName');

        if( !empty( $productName )){
            $query->where( 'products.productName', 'LIKE', "%$productName%" );
        }

        if( !empty( $companyId )){
            $query->where('companies.company_id', $companyId );
        }

        $products = $query->get();

        return view('list', [ 'products' => $products, 'companies' => $companies ]);
    }

    //削除処理
    public function productDestroy($id)
    {
        Product::destroy($id);
        return redirect(route('products'));
    }



    /**
     * 商品詳細を表示する
     * @param int $id
     * @return view
     */

    public function showDetail($id) {
        $companies = Company::all();
        $product = Product::find($id);

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('products'));
        }

        return view('detail', [ 'product' => $product ]);
    }

    /**
     * 商品登録画面を表示する
     *
     * @return view
     */
    public function showCreate() {
        $companies = Company::all();
        return view('form', compact('companies'));
    }

    /**
     * 商品を新規登録する
     *
     * @return view
     */
    public function exeStore(ProductRequest $request) {
        $companies = Company::all();
        //listbladeのデータを受け取る
        $inputs = $request->all();
        logger($inputs);
        //dd($inputs);

        \DB::beginTransaction();
        try {
            logger($request->hasFile('imgPath'));
            logger(__LINE__);
            if($request->hasFile('imgPath')) {
                logger(__LINE__);
                $file = $request->file('imgPath');
                $name = $file->getClientOriginalName();
                InterventionImage::make($file)->resize(1080, 700)->save(public_path( 'storage/' . $name ) );
            } else {
                logger(__LINE__);
                $name = null;
            }
            logger(__LINE__);
            $inputs['imgPath'] = $name;
            logger(__LINE__);
            logger($inputs);
            Product::create($inputs);
            \DB::commit();
        }catch(\Throwable $e) {
            //登録されずにエラーページ500が表示される
            logger(__LINE__);
            var_dump($e->getMessage());
            \DB::rollback();
            abort(500);
        }

        //商品を登録する
        \Session::flash( 'err_msg', '商品を登録しました！' );
        return redirect( route( 'create' ));
    }

    /**
     * 商品編集フォームを表示する
     * @param int $id
     * @return view
     */

    public function showEdit($id) {
        $companies = Company::all();
        $product = Product::find($id);
        return view( 'edit', [ 'product' => $product, 'companies' => $companies ]);
    }

    /**
     * 商品情報を更新する
     *
     * @return view
     */
    public function exeUpdate(ProductRequest $request) {
        $companies = Company::all();
        //商品一覧からデータを受け取る
        $inputs = $request->all();
        //dd($inputs);
        //$inputsの中身を確認できる

        \DB::beginTransaction();
        try {

            if($request->hasFile('imgPath')) {
                logger(__LINE__);
                $fileName = $request->file('imgPath')->store('public');
            } else {
                logger(__LINE__);
                $fileName = null;
            }

            $product = Product::find( $inputs[ 'id' ]);
            $product->fill([
                'productName' => $inputs[ 'productName' ],
                'companyName' => $inputs[ 'companyName' ],
                'price' => $inputs[ 'price' ],
                'stock' => $inputs[ 'stock' ],
                'comment' => $inputs[ 'comment' ],
            ]);

            if($fileName) {
                $product->imgPath = $fileName;
            }

            $product->save();

            \DB::commit();
        }catch(\Throwable $e) {
            //登録されずにエラーページ500が表示される
            var_dump($e->getMessage());
            \DB::rollback();
            abort(500);
        }

        //商品情報を更新する
        \Session::flash('err_msg', '商品情報を更新しました！');
        return redirect( route( 'edit', ['id' => $inputs['id']], compact('companies')));
    }

}
