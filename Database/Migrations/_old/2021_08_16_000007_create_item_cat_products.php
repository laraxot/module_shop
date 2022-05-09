<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//----- models -----
//----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateHomesTable.
 */
class CreateItemCatProducts extends XotBaseMigration {
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
                    $table->integer('item_cat_id')->nullable();
                    $table->integer('item_cat_product_id')->nullable();
                    $table->string('item_cat_product_type')->nullable();
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
                /*
                if ($this->hasColumn('post_id')) {
                    $table->renameColumn('post_id', 'id');
                }
                */
            }
        );
    }
}
