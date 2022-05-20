<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//----- models -----
//----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateHomesTable.
 */
class CreatePricesTable extends XotBaseMigration {
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
                    $table->nullableMorphs('post');
                    $table->integer('price_type_id')->nullable(); //es: pranzo è 1, cena è 2
                    $table->string('price_currency', 4)->nullable();
                    $table->decimal('price', 10, 3)->nullable();
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
                if (! $this->hasColumn('product_id')) {
                    $table->integer('product_id');
                }
                if ($this->hasColumn('price_type_id')) {
                    $table->renameColumn('price_type_id', 'cat_id');
                }
            }
        );
    }
}
