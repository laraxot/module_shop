<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//----- models -----
//----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateHomesTable.
 */
class CreateProductItemsTable extends XotBaseMigration {
    /**
     * db up.
     *
     * @return void
     */
    public function up() {
        //-- CREATE --
        if (! $this->tableExists()) {
            $this->getConn()->create(
                $this->getTable(),
                function (Blueprint $table) {
                    $table->increments('id'); //->primary();
                    $table->string('price_currency', 4)->nullable();
                    $table->decimal('price', 10, 3)->nullable();
                    $table->integer('item_cat_id')->nullable();
                    $table->string('created_by')->nullable();
                    $table->string('updated_by')->nullable();
                    $table->timestamps();
                }
            );
        }
        //-- UPDATE --
        $this->getConn()->table(
            $this->getTable(),
            function (Blueprint $table) {
                if ($this->hasColumn('id_item_cat')) {
                    $table->renameColumn('id_item_cat', 'item_cat_id');
                }
                /*
                if (! $this->hasColumn('icon_src')) {
                    $table->string('icon_src')->nullable();
                }
                */
            }
        );
    }
}
