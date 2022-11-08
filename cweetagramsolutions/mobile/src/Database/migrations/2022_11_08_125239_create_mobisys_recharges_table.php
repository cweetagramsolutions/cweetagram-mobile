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
        Schema::create('mobisys_recharges', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('msisdn');
            $table->string('recharge_type');
            $table->string('amount_in_cents');
            $table->string('product_code');
            $table->text('provider_response')->nullable();
            $table->string('state')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobisys_recharges');
    }
};
