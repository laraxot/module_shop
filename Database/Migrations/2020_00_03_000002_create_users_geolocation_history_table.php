<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'users_geolocation_history' already exists (SQL: create table `users_geolocation_history` (`id` bigint unsigned not null auto_increment primary key, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null, `ip_api` json null, `extreme_ip_lookup` json null, `order_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreateUsersGeolocationHistoryTable extends XotBaseMigration {
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

                $table->json('ip_api')->nullable();
                $table->json('extreme_ip_lookup')->nullable();

                //$this->addForeignKey($table, 'user_id', $this->getTableName('users'), false); //da vedere come fare
                $this->addForeignKey($table, 'order_id', $this->getTableName('orders'), true);
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
