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
        Schema::create('bank_account', function (Blueprint $table) {
            $table->id();
            $table->string('account_no')->nullable()->unique();
            $table->string('sheba_no')->nullable()->unique();
            $table->unsignedInteger('payment_no')->nullable()->unique();
            $table->unsignedSmallInteger('user_id')->index()->nullable();
            $table->unsignedSmallInteger('bank_id')->index()->nullable();

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
        Schema::dropIfExists('bank_account');
    }
};
