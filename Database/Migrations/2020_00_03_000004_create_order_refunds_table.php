<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'order_refunds' already exists (SQL: create table `order_refunds` (`id` bigint unsigned not null auto_increment primary key, `created_at` timestamp null, `updated_at` timestamp null, `refund_reason` longtext null, `refund_amount` varchar(191) null, `status` enum('pending', 'treatment', 'partial-refund', 'refunded', 'cancelled', 'rejected') not null default 'pending', `notes` longtext not null, `order_id` bigint unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreateOrderRefundsTable extends XotBaseMigration {
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

                $table->longText('refund_reason')->nullable();
                $table->string('refund_amount')->nullable();
                $table->enum('status', ['pending', 'treatment', 'partial-refund', 'refunded', 'cancelled', 'rejected'])->default('pending');
                $table->longText('notes');

                $this->addForeignKey($table, 'order_id', $this->getTableName('orders'), false);
                //$this->addForeignKey($table, 'user_id', $this->getTableName('users')); //da vedere come fare
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
