<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'products', function( $table ){
            $table->increments( 'id' );
            $table->text( 'imgPath' )->nullable();
            $table->string( 'productName' );
            $table->integer( 'price' );
            $table->integer( 'stock' );
            $table->string( 'companyName' );
            $table->text( 'comment' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'products' );
    }
}
