<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'user_addresses' already exists (SQL: create table `user_addresses` (`id` bigint unsigned not null auto_increment primary key, `created_at` timestamp null, `updated_at` timestamp null, `last_name` varchar(191) not null, `first_name` varchar(191) not null, `company_name` varchar(191) null, `street_address` varchar(191) not null, `street_address_plus` varchar(191) null, `zipcode` varchar(191) not null, `city` varchar(191) not null, `phone_number` varchar(191) null, `is_default` tinyint(1) not null default '0', `type` enum('billing', 'shipping') not null, `country_id` bigint unsigned null, `user_id` bigint unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreateUserAddressesTable extends XotBaseMigration {
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

                $table->string('last_name');
                $table->string('first_name');
                $table->string('company_name')->nullable();
                $table->string('street_address');
                $table->string('street_address_plus')->nullable();
                $table->string('zipcode');
                $table->string('city');
                $table->string('phone_number')->nullable();
                $table->boolean('is_default')->default(false);
                $table->enum('type', ['billing', 'shipping']);

                //$this->addForeignKey($table, 'country_id', $this->getTableName('system_countries'));
                //$this->addForeignKey($table, 'user_id', $this->getTableName('users'), false);
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
