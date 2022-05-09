<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//----- models -----
//----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateNightclubsTable.
 */
class CreateNightclubsTable extends XotBaseMigration {
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
                    $table->string('phone', 50)->nullable();
                    $table->string('website')->nullable();
                    $table->string('email')->nullable();
                    $table->string('vat_number')->nullable(); //partita iva
                    $table->string('tax_code')->nullable(); //codice fiscale
                    $table->integer('status_id')->default(0);
                    $table->boolean('is_reclamed')->default(0);

                    $table->string('created_by')->nullable();
                    $table->string('updated_by')->nullable();
                    $table->timestamps();
                }
            );
        }

        //-- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                /*
                if (! $this->hasColumn('post_id')) {
                    $table->integer('post_id')->nullable();
                }
                */
            }
        );
    }
}
