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
        Schema::create('unb_ussd_draws', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('state')->default('pending');
            $table->timestamps();
        });

        Schema::create('unb_ussd_winners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('draw_id');
            $table->string('sessionid');
            $table->string('msisdn');
            $table->timestamps();

            $table->foreign('draw_id')
                ->references('id')
                ->on('unb_ussd_draws')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unb_ussd_winners');
        Schema::dropIfExists('unb_ussd_draws');
    }
};
