<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateOrderShippingsTable extends XotBaseMigration {
    use \Modules\Shop\Database\Migrations\Traits\MigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //-- CREATE --
        $this->tableCreate(
            function (Blueprint $table) {
                $this->addCommonFields($table);

                $table->date('shipped_at');
                $table->date('received_at');
                $table->date('returned_at');
                $table->string('tracking_number')->nullable();
                $table->string('tracking_number_url')->nullable();
                $table->json('voucher')->nullable();

                $this->addForeignKey($table, 'order_id', $this->getTableName('orders'), false);
                $this->addForeignKey($table, 'carrier_id', $this->getTableName('carriers'));
            });

        //-- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                /*
                if ($this->hasColumn('auth_user_id') && ! $this->hasColumn('user_id')) {
                    $table->renameColumn('auth_user_id', 'user_id');
                }
                */
            }
        );
    }
}
