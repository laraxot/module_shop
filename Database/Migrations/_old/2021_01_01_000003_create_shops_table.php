<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
//----- models -----
//----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateHomesTable.
 */
class CreateShopsTable extends XotBaseMigration {
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
                    $table->string('shop_type', 50)->nullable(); //tipo shop (ristorante, fioraio, ecc)
                    $table->string('phone', 50)->nullable();
                    $table->string('website')->nullable();
                    $table->string('email')->nullable();
                    $table->string('vat_number')->nullable(); //partita iva
                    $table->string('tax_code')->nullable(); //codice fiscale
                    $table->decimal('ratings_avg', 10, 3);
                    $table->integer('ratings_count')->default(0);
                    $table->integer('status_id')->default(0);
                    $table->boolean('is_reclamed')->default(0);
                    $table->boolean('booking_enable')->default(0);
                    $table->boolean('order_enable')->default(0);

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
                if (! $this->hasColumn('locality')) {
                    $table->string('locality')->nullable();
                }

                if (! $this->hasColumn('locality_slug')) {
                    $table->string('locality_slug')->nullable();
                }

                /*
                if ($this->hasColumn('post_id')) {
                    $table->renameColumn('post_id', 'id');
                }
                */
            }
        );
    }
}
