<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('symbol');
            $table->string('external_id');
            $table->boolean('active')->default(false);

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
        Schema::dropIfExists('coins');
    }
}
