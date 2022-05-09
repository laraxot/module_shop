<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateModelHasRolesTables extends XotBaseMigration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //$tableNames = TenantService::config('permission.table_names');
        //$columnNames = TenantService::config('permission.column_names');

        $tableNames = [
            'roles' => 'roles',
            'permissions' => 'permissions',
            'model_has_permissions' => 'model_has_permissions',
            'model_has_roles' => 'model_has_roles',
            'role_has_permissions' => 'role_has_permissions',
        ];
        $columnNames = ['model_morph_key' => 'model_id']; //momentaneamente

        //-- CREATE --
        $this->tableCreate(
            function (Blueprint $table) use ($columnNames, $tableNames) {
                $table->unsignedBigInteger('role_id');

                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

                /*
                $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
                */

                $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
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
