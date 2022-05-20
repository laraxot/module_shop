<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateProductsTable extends XotBaseMigration {
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

                $table->string('name');
                $table->string('slug')->unique()->nullable();
                $table->string('sku')->unique()->nullable();
                $table->string('barcode')->unique()->nullable();
                $table->longText('description')->nullable();
                $table->integer('security_stock')->default(0);
                $table->boolean('featured')->default(false);
                $table->boolean('is_visible')->default(false);
                $table->integer('old_price_amount')->nullable();
                $table->integer('price_amount')->nullable();
                $table->integer('cost_amount')->nullable();
                $table->enum('type', ['deliverable', 'downloadable'])->nullable();
                $table->boolean('backorder')->default(false);
                $table->boolean('requires_shipping')->default(false);
                $table->dateTimeTz('published_at')->default(now())->nullable();

                $this->addSeoFields($table);
                $this->addShippingFields($table);

                $this->addForeignKey($table, 'parent_id', $this->getTableName('products'));
                $this->addForeignKey($table, 'brand_id', $this->getTableName('brands'));
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
