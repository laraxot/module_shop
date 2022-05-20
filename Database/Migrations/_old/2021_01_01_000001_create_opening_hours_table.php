<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateOpeningHoursTable.
 */
class CreateOpeningHoursTable extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        //-- CREATE --
        if (! $this->tableExists()) {
            $this->getConn()->create(
                $this->getTable(),
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('post_id');
                    $table->string('day_name');
                    $table->integer('day_of_week');
                    $table->time('open_at')->nullable();
                    //time or timeTz ??
                    $table->time('close_at')->nullable();

                    $table->boolean('is_closed')->nullable();
                    $table->text('note')->nullable();
                    $table->string('created_by')->nullable();

                    $table->string('updated_by')->nullable();

                    $table->string('deleted_by')->nullable();

                    $table->ipAddress('created_ip')->nullable();

                    $table->ipAddress('updated_ip')->nullable();

                    $table->ipAddress('deleted_ip')->nullable();
                    //$table->ipAddress('visitor');	IP address equivalent column.

                    $table->timestamps();
                    $table->softDeletes();
                }
            );
        }

        //-- UPDATE --
        $this->getConn()->table(
            $this->getTable(),
            function (Blueprint $table) {
                if (! $this->hasColumn('is_closed')) {
                    $table->boolean('is_closed')->nullable();
                }
                if (! $this->hasColumn('post_type')) {
                    $table->string('post_type')->index()->nullable();
                }
                if (! $this->hasColumn('deleted_by')) {
                    $table->string('deleted_by')->nullable();
                }
                //-------------- CHANGE -------------
                if ($this->hasColumn('deleted_by')) {
                    $table->string('deleted_by')->nullable()->change();
                }
                if ($this->hasColumn('created_ip')) {
                    $table->string('created_ip')->nullable()->change();
                }
                if ($this->hasColumn('updated_ip')) {
                    $table->string('updated_ip')->nullable()->change();
                }
                if ($this->hasColumn('deleted_ip')) {
                    $table->string('deleted_ip')->nullable()->change();
                }
                if ($this->hasColumn('open_at')) {
                    $table->time('open_at')->nullable()->change();
                }
                if ($this->hasColumn('close_at')) {
                    $table->time('close_at')->nullable()->change();
                }
            }
        );
    }
}
