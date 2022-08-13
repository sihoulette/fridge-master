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
        Schema::create('location_room', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id')
                ->unsigned()
                ->comment('Location ID');
            $table->string('name')
                ->comment('Name');
            $table->float('temperature', 4, 2)
                ->default(0.00)
                ->comment('Temperature, °C');
            $table->timestamps();
            // Foreign keys
            $table->foreign('location_id')
                ->references('id')
                ->on('location')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('location_room');
    }
};
