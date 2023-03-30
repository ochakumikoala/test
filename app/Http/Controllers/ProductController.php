<?php

namespace App\Http\Controllers;

use App\Components\ExifComponent;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use \InterventionImage;
use Illuminate\View\View;


class ProductController extends Controller
{
    private $product;
    private $company;

    public function __construct(Product $product, Company $company) {
        $this->product = new Product();
        $this->company = new Company();
    }

    /**
     * 商品一覧を表示する
     *
     * @param $request
     * @return view
     */

    public function index(Request $request) {
        $products = Product::query();
        // $companies = Company::query();
        $product_name = $request->input( 'product_name' );
        $company_id = $request->input( 'company_name' );
        $max_price = $request->input('max_price');
        $min_price = $request->input('min_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');

        $products = Product::sortable();
        $products = $this->product
            ->getProducts($product_name, $company_id, $max_price, $min_price, $min_stock, $max_stock);
        

        return view('index', [ 
            'products' => $products, 
            'companies' => $this->company->getAll(), 
            'price' => $max_price, 
            'price' => $min_price,
            'stock' => $max_stock,
            'stock' => $min_stock,
        ]);
    }
    
    /**
     * 削除処理
     *
     * @param int $id
     * @return view
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect(route('products'));
    }

    /**
     * 商品詳細を表示する
     *
     * @param int $id
     * @return view
     */
    public function show($id) {
        $product = Product::find($id);
        if (empty($product) == config('const.err_log.error')) {
            return redirect(route('index'));
        }
        return view( 'detail', compact('product') );
    }

    /**
     * 商品登録画面を表示する
     *
     * @return view
     */
    public function create() {
        $companies = $this->company->all();
        $route = route('create');
        $method = 'post';
        return view('form')->with(compact('companies', 'route', 'method'));
    }

    /**
     * 商品を新規登録する
     *
     * @return view
     */
    public function store(Request $request) {
        $registerProduct = $this->product->createProduct($request);
        return redirect( route( 'create' ));
    }

    /**
     * 商品編集フォームを表示する
     * @param int $id
     * @return view
     */

    public function edit($id) {
        $companies = $this->company->all();
        $product = Product::find($id);
        if (empty($product) == config('const.err_log.error')) {
            return redirect(route('index'));
        }
        return view( 'edit', compact('companies', 'product') );
    }

    /**
     * 商品情報を更新する
     *
     * @params id, $request
     * @return view
     */

    public function update(Request $request) {
        $product_model = new Product();
        $id = $request->product_id;
        $product = Product::find($id);
        $product_model->updateProduct($request, $id);
        return redirect( route( 'edit', ['id' => $id] ));
    }


    //画像を表示させる
    public function image(Request $request, Product $product) {
        // バリデーション省略
        $originalImg = $request->img_path;
      
          if($originalImg->isValid()) {
            $filePath = $originalImg->store('public');
            $product->image = str_replace('public', '', $filePath);
            $product->save();
          }
    }
}