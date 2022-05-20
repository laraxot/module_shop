<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class Information extends XotBaseMigration {
    /**
     * Undocumented function.
     *
     * @return void
     */
    public function up() {
        if (! $this->tableExists()) {
            $this->getConn()->create(
                $this->getTable(),
                function (Blueprint $table) {
                    $table->string('id');
                    $table->string('business_name');
                    $table->string('address');
                    $table->string('phone');
                    $table->string('url');
                    $table->string('email');
                    $table->string('tax_id_code');
                    $table->string('vat_number');

                    $table->string('created_by')->nullable();
                    $table->string('updated_by')->nullable();
                    $table->timestamps();
                });
        }
    }
}
