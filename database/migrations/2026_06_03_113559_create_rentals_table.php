<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bike_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pickup_station_id')
                ->constrained('stations')
                ->cascadeOnDelete();
            $table->foreignId('return_station_id')
                ->nullable()
                ->constrained('stations')
                ->nullOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->default('active');
            $table->decimal('base_price', 8, 2);
            $table->integer('base_minute');
            $table->decimal('extra_price', 8, 2);
            $table->integer('extra_minute');
            $table->integer('duration_minute')->nullable();
            $table->decimal('total_price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
