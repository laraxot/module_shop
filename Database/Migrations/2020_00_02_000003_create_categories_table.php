<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'categories' already exists (SQL: create table `categories` (`id` bigint unsigned not null auto_increment primary key, `created_at` timestamp null, `updated_at` timestamp null, `name` varchar(191) not null, `slug` varchar(191) null, `description` longtext null, `position` smallint unsigned not null default '0', `is_enabled` tinyint(1) not null default '0', `seo_title` varchar(60) null, `seo_description` varchar(160) null, `parent_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreateCategoriesTable extends XotBaseMigration {
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

                $table->string('name');
                $table->string('slug')->unique()->nullable();
                $table->longText('description')->nullable();
                $table->unsignedSmallInteger('position')->default(0);
                $table->boolean('is_enabled')->default(false);

                $this->addSeoFields($table);
                $this->addForeignKey($table, 'parent_id', $this->getTableName('categories'));
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
