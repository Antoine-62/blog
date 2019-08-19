<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_product', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('Title');
			$table->string('FirstName');
			$table->string('LastName');	
			$table->date('birth');
			$table->string('City');
			$table->string('Country');
			$table->string('Mail');
			$table->string('Phone'); 	
			$table->string('PreferC');
			$table->string('filename');
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
        Schema::dropIfExists('_product');
    }
}
