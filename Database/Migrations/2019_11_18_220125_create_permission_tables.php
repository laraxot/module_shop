<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * module:migrate shop --force non effettuato SQLSTATE[42S01]:
 * Base table or view already exists: 1050 Table 'permissions' already exists
 * (SQL: create table `permissions`
 * (`id` bigint unsigned not null auto_increment primary key,
 * `name` varchar(191) not null, `guard_name` varchar(191) not null,
 * `group_name` varchar(191) null, `display_name` varchar(191) null,
 * `description` varchar(191) null,
 * `can_be_removed` tinyint(1) not null default '1', `created_at` timestamp null, `updated_at` timestamp null)
 * default character set utf8mb4 collate 'utf8mb4_unicode_ci').
 */
class CreatePermissionTables extends XotBaseMigration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tableNames = config('shop::permission.table_names');
        $columnNames = config('shop::permission.column_names');

        //-- CREATE --
        $this->tableCreate(
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->string('group_name')->nullable();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->boolean('can_be_removed')->default(true);
                $table->timestamps();
            });

        /*Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('can_be_removed')->default(true);
            $table->timestamps();
        });
        */

        /*
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });
         */

        /*
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });
         */

        /*
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });
        */

        app('cache')
            ->store('default' != config('permission.cache.store') ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

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
