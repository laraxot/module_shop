<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateCollectionRulesTable extends XotBaseMigration {
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

                $table->string('rule'); // defaults: ['product_title', 'product_price', 'compare_at_price', 'inventory_stock', 'product_brand', 'product_category']
                $table->string('operator'); // defaults: ['equals_to', 'not_equals_to', 'less_than', 'greater_than', 'starts_with', 'ends_with', 'contains', 'not_contains']
                $table->string('value');

                //$this->addForeignKey($table, 'collection_id', $this->getTableName('collections'), false);
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
