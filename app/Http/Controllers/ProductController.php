<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductListRequest;
use Illuminate\Support\Facades\DB;
use Validator;
use \InterventionImage;
use Illuminate\View\View;


class ProductController extends Controller
{
    private Product $product;
    private Company $company;

    public function __construct(Product $product, Company $company) {
        $this->product = $product;
        $this->company = $company;
    }



    /**
     * 商品一覧を表示する
     *
     * @return view
     */

    public function productList(Request $request): View{
        // $validated = $request->validated();
        $productName = $request->input( 'productName' );
        $companyId = $request->input( 'companyName' );
        
        $products = $this->product->getProducts($productName, $companyId);

        return view('list', [ 'products' => $products, 'companies' => $this->company->getAll()]);
    }

    //削除処理
    public function productDestroy($id)
    {
        return redirect(route('products'));
    }



    /**
     * 商品詳細を表示する
     * @param int $id
     * @return view
     */

    public function showDetail($id) {
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
        return view('form', ['companies' => $this->company->getAll()]);
    }

    /**
     * 商品を新規登録する
     *
     * @return view
     */
    public function exeStore(ProductRequest $request) {
        $companyId = $request->input( 'company_id' );
        $companyName = $this->company->findById($companyId)->companyName;
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $name = null;
            if($request->hasFile('imgPath')) {
                $file = $request->file('imgPath');
                $name = $file->getClientOriginalName();
                InterventionImage::make($file)->resize(1080, 700)->save(public_path( 'storage/' . $name ) );
            }
            $inputs['imgPath'] = $name;
            $inputs['companyName'] = $companyName;
            $this->product->createProduct($inputs);
            \DB::commit();
        }catch(\Throwable $e) {
            \DB::rollback();
        }

        \Session::flash( 'err_msg', '商品を登録しました！' );
        return redirect( route( 'create' ));
    }

    /**
     * 商品編集フォームを表示する
     * @param int $id
     * @return view
     */

    public function showEdit($id) {
        return view( 'edit', [ 'product' => $this->product->findById($id), 'companies' => $this->company->getAll()]);
    }

    /**
     * 商品情報を更新する
     *
     * @return view
     */
    public function exeUpdate(ProductRequest $request) {

        //商品一覧からデータを受け取る
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $name = null;
            $companyId = $request->input( 'company_id' );
            $companyName = $this->company->findById($companyId)->companyName;
            if($request->hasFile('imgPath')) {
                $file = $request->file('imgPath');
                $name = $file->getClientOriginalName();
                InterventionImage::make($file)->resize(1080, 700)->save(public_path( 'storage/' . $name ) );
            }
            $inputs['imgPath'] = $name;
            $inputs['companyName'] = $companyName;
            $this->product->updateProduct($inputs);

            \DB::commit();
        }catch(\Throwable $e) {
            //登録されずにエラーページ500が表示される
            \DB::rollback();
        }

        //商品情報を更新する
        \Session::flash('flash_msg', '商品情報を更新しました！');
        return redirect( route( 'edit', ['id' => $inputs['id'], 'companies' => $this->company->getAll()] ));
    }

}
