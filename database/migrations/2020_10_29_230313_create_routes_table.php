<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order');
            $table->decimal('start_lon', 10, 7);
            $table->decimal('start_lat', 10, 7);
            $table->decimal('finish_lon', 10, 7);
            $table->decimal('finish_lat', 10, 7);
            $table->float('distance_km', 8, 2);
            $table->unsignedBigInteger('length_min');
            $table->foreignId('journey_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('routes');
    }
}
