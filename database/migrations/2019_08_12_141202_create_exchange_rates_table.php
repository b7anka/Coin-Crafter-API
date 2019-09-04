<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('currency');
            $table->string('value')->default('0.0');
            $table->string('date')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_pt')->nullable();
            $table->string('symbol')->nullable();
            $table->tinyInteger('all_currencies')->default(1);
            $table->tinyInteger('most_valuable')->default(0);
            $table->tinyInteger('crypto')->default(0);
            $table->tinyInteger('most_traded')->default(0);
            $table->longText('img');
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
        Schema::dropIfExists('exchange_rates');
    }
}
