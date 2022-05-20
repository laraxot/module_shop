<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateInventoriesTable extends XotBaseMigration {
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
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->string('email')->unique();
                $table->string('street_address');
                $table->string('street_address_plus')->nullable();
                $table->string('zipcode');
                $table->string('city');
                $table->string('phone_number')->nullable();
                $table->integer('priority')->default(0);
                $table->decimal('latitude', 10, 5)->nullable();
                $table->decimal('longitude', 10, 5)->nullable();
                $table->boolean('is_default')->default(false);

                $this->addForeignKey($table, 'country_id', $this->getTableName('system_countries'));
            });

        /*Schema::create($this->getTableName('inventory_histories'), function (Blueprint $table) {
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
        */

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
