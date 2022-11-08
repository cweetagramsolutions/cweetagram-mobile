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
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->string('barcode');
            $table->string('digits');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('barcodes')
            ->insert([
               [
                   'product' => 'Chibuku Unit',
                   'barcode' => '6 009 605 330 219',
                   'digits' => '0219',
                   'created_at' => \Carbon\Carbon::now()
               ],
                [
                    'product' => 'Chibuku Shrink',
                    'barcode' => '6 009 605 330 745',
                    'digits' => '0745',
                    'created_at' => \Carbon\Carbon::now()
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barcodes');
    }
};
