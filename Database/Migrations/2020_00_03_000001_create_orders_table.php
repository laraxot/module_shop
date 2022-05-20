<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'orders' already exists (SQL: create table `orders` (`id` bigint unsigned not null auto_increment primary key, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null, `number` varchar(32) not null, `price_amount` int null, `status` varchar(32) not null, `currency` varchar(191) not null, `shipping_total` int null, `shipping_method` varchar(191) null, `notes` text null, `parent_order_id` bigint unsigned null, `shipping_address_id` bigint unsigned null, `payment_method_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreateOrdersTable extends XotBaseMigration {
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
                $this->addCommonFields($table, true);

                $table->string('number', 32);
                $table->integer('price_amount')->nullable();
                $table->string('status', 32);
                $table->string('currency');
                $table->integer('shipping_total')->nullable();
                $table->string('shipping_method')->nullable();
                $table->text('notes')->nullable();

                $this->addForeignKey($table, 'parent_order_id', $this->getTableName('orders'));
                $this->addForeignKey($table, 'shipping_address_id', $this->getTableName('user_addresses'));
                //$this->addForeignKey($table, 'user_id', $this->getTableName('users')); // da vedere come fare
                $this->addForeignKey($table, 'payment_method_id', $this->getTableName('payment_methods'));
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
