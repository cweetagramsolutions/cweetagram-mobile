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
        Schema::create('unb_ussd_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sessionid');
            $table->string('msisdn');
            $table->string('network');
            $table->string('barcode_input')->nullable();
            $table->string('state')->default('negative');
            $table->timestamps();
        });

        Schema::create('unb_ussd_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('sessionid');
            $table->string('msisdn');
            $table->string('age_group')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('unb_ussd_logs');
        Schema::dropIfExists('unb_ussd_surveys');
    }
};
