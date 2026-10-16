<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('refuel_date');
            $table->decimal('liters', 8, 2);
            $table->decimal('cost_per_liter', 10, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->integer('odometer_km')->nullable();
            $table->string('fuel_station')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('service_date');
            $table->string('service_type');
            $table->text('description')->nullable();
            $table->integer('odometer_km')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->string('workshop')->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('next_service_km')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('service_records');
        Schema::dropIfExists('fuel_records');
    }
};
