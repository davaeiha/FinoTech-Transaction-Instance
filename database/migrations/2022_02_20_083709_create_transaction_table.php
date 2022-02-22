<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('source_account_id');
            $table->unsignedSmallInteger('destination_account_id');
            $table->dateTime('payment_time')->nullable();
            $table->unsignedInteger('ref_code')->unique()->nullable();
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('reason')->nullable();
            $table->unsignedSmallInteger('type_id')->nullable();
            $table->unsignedTinyInteger('status')->nullable()
                ->comment('0:failed / 1:pending / 2:done');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
};
