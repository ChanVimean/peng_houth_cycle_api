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
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            // Type: normal, electric
            $table->string('type')->default('electric');
            // Status: available, unavailable
            $table->string('status')->default('available');
            $table->integer('battery_level')->nullable();
            $table->decimal('base_price', 8, 2)->default(0.00);
            $table->integer('base_minute');
            $table->decimal('extra_price', 8, 2)->default(0.00);
            $table->integer('extra_minute');
            $table->text('description')->nullable();
            $table->timestamps();
            // base_minutes
            // base_price
            // extra_minutes
            // extra_price
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};
