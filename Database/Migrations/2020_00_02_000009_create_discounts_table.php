<?php

declare(strict_types=1);

//namespace Modules\Shop\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateDiscountsTable extends XotBaseMigration {
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

                $table->boolean('is_active')->default(false);
                $table->string('code')->unique()->index();
                $table->string('type');
                $table->integer('value');
                $table->string('apply_to');
                $table->string('min_required');
                $table->string('min_required_value')->nullable();
                $table->string('eligibility');
                $table->unsignedInteger('usage_limit')->nullable();
                $table->boolean('usage_limit_per_user')->default(false);
                $table->unsignedInteger('total_use')->default(0);
                $table->dateTime('start_at');
                $table->dateTime('end_at')->nullable();
            });

        /*
        Schema::create($this->getTableName('discountables'), function (Blueprint $table) {
            $this->addCommonFields($table);
            $table->string('condition')->nullable(); // apply_to, eligibility
            $table->unsignedInteger('total_use')->default(0);
            $table->morphs('discountable');

            $this->addForeignKey($table, 'discount_id', $this->getTableName('discounts'), false);
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
