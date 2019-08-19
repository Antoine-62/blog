<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductQ extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_product_q', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('Name');
			$table->string('Category');	
			$table->double('Price');
			$table->string('ProductS');
			$table->string('Uid');
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
        Schema::dropIfExists('_product_q');
    }
}
