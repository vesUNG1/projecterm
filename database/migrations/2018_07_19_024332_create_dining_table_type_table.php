<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiningTableTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('dining_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('qrimage');
            $table->string('qrcode');
            $table->string('seating');
            $table->string('color');
            $table->string('status');
            $table->tinyInteger('is_active')->default(1);
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
         Schema::dropIfExists('dining_table');
    }
}
