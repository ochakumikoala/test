<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

//ログインしていないとログイン画面以外の表示はされない
Route::middleware([ 'auth' ])->prefix( 'product' )->group( function () {
    //商品一覧画面を表示
    Route::get( '/', 'ProductController@productList' )->name( 'products' );
    Route::post( '/search', 'ProductController@productSearch' )->name( 'search' );

    //商品の削除
    Route::delete( '/destroy/{id}', 'ProductController@productDestroy' )->name( 'delete' );

    //商品登録画面を表示
    Route::get( '/create', 'ProductController@showCreate' )->name( 'create' );

    //商品登録
    Route::post( '/store', 'ProductController@exeStore' )->name( 'store' );

    //商品詳細画面を表示
    Route::get( '/{id}', 'ProductController@showDetail' )->name( 'detail' );

    //商品編集画面を表示
    Route::get( '/edit/{id}', 'ProductController@showEdit' )->name( 'edit' );
    Route::post( '/update', 'ProductController@exeUpdate' )->name( 'update' );

});

//ログアウト後ログイン画面を表示
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');
