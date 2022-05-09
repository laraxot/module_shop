<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//non lo estendo con xotbasemigration perchè altrimenti mi crea la tabella plurare shop_shop_cats
class CreateShopShopCatTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('shop_shop_cat', function (Blueprint $table) {
            $table->integer('shop_id');
            $table->integer('shop_cat_id');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('shop_shop_cat');
    }
}
