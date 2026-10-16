<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->enum('type', ['passenger', 'cargo']); // angkutan orang, angkutan barang
            $table->enum('ownership', ['own', 'rental']); // milik perusahaan, sewa
            $table->string('rental_company')->nullable();
            $table->string('location'); // region/lokasi tambang
            $table->integer('fuel_capacity')->default(60); // liter
            $table->decimal('fuel_consumption', 8, 2)->default(10); // km/liter
            $table->date('last_service_date')->nullable();
            $table->integer('last_service_km')->nullable();
            $table->integer('next_service_km')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'retired'])->default('available');
            $table->string('color')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
