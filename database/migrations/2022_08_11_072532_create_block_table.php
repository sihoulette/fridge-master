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
        Schema::create('block', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->comment('Name');
            $table->float('length', 4, 2, true)
                ->default(0.00)
                ->comment('Length, m.');
            $table->float('width', 4, 2, true)
                ->default(0.00)
                ->comment('Width, m.');
            $table->float('height', 4, 2, true)
                ->default(0.00)
                ->comment('Height, m');
            $table->float('volume', 8, 2, true)
                ->default(0.00)
                ->comment('Volume, м3');
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
        Schema::dropIfExists('block');
    }
};
