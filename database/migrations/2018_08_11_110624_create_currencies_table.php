<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('code');
            $table->string('exchange_rate');
        });

        DB::table('currencies')->insert([
            [
                'code' => 'DOL',
                'exchange_rate' => 68
            ],
            [
                'code' => 'EUR',
                'exchange_rate' => 78
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
        Schema::dropIfExists('currencies');
    }
}
