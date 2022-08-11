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
        Schema::create('location_room_block', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('block_id')
                ->unsigned()
                ->comment('Block ID');
            $table->bigInteger('location_id')
                ->unsigned()
                ->comment('Location ID');
            $table->bigInteger('location_room_id')
                ->unsigned()
                ->comment('Location room ID');
            $table->smallInteger('quantity')
                ->unsigned()
                ->comment('Quantity');
            $table->timestamps();
            // Foreign keys
            $table->foreign('block_id')
                ->references('id')
                ->on('block')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('location_id')
                ->references('id')
                ->on('location')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('location_room_id')
                ->references('id')
                ->on('location_room')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // Indexes
            $table->unique(['block_id', 'location_id', 'location_room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_room_block');
    }
};
