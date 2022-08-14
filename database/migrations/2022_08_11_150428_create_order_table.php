<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Order lifecycle process statuses
     *
     * @var array|string[] $statuses
     */
    static protected array $statuses = [
        'new',
        'reserved',
        'in-delivery',
        'in-storage',
        'out-storage',
        'out-delivery',
        'complete',
        'block',
        'abort'
    ];

    /**
     * Default order status
     *
     * @var string $defStatus
     */
    static protected string $defStatus = 'new';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')
                ->unsigned()
                ->nullable()
                ->comment('User ID');
            $table->string('access_code')
                ->unique()
                ->comment('Access code hash');
            $table->bigInteger('location_id')
                ->unsigned()
                ->nullable()
                ->comment('Location ID');
            $table->float('temperature', 4, 2)
                ->default(0.00)
                ->comment('Temperature, °C');
            $table->float('volume', 8, 2, true)
                ->default(0.00)
                ->comment('Volume, м3');
            $table->enum('status', self::$statuses)
                ->default(self::$defStatus)
                ->comment('Order status');
            $table->string('name')
                ->comment('Name');
            $table->string('email')
                ->comment('E-mail');
            $table->timestamp('beginning_at')
                ->nullable()
                ->comment('Beginning storage');
            $table->timestamp('ending_at')
                ->nullable()
                ->comment('Ending storage');
            $table->timestamps();
            // Foreign keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('location_id')
                ->references('id')
                ->on('location')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
