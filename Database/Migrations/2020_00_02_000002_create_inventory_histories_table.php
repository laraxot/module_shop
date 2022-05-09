<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateInventoryHistoriesTable extends XotBaseMigration {
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

                $table->morphs('stockable');
                $table->string('reference_type')->nullable();
                $table->unsignedBigInteger('reference_id')->nullable();
                $table->integer('quantity');
                $table->integer('old_quantity')->default(0);
                $table->text('event')->nullable();
                $table->text('description')->nullable();

                $this->addForeignKey($table, 'inventory_id', $this->getTableName('inventories'), false);
                //$this->addForeignKey($table, 'user_id', $this->getTableName('users'), false);  // da studiare come fare
                $table->index(['reference_type', 'reference_id']);
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
