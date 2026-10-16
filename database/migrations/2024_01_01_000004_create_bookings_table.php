<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pemohon
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->string('purpose');
            $table->text('description')->nullable();
            $table->string('destination');
            $table->datetime('departure_datetime');
            $table->datetime('return_datetime');
            $table->integer('passenger_count')->default(1);
            $table->enum('status', [
                'pending',        // menunggu persetujuan level 1
                'approved_l1',    // disetujui level 1, menunggu level 2
                'approved_l2',    // disetujui level 2 (final)
                'rejected',       // ditolak
                'cancelled',      // dibatalkan
                'in_use',         // sedang digunakan
                'completed',      // selesai
            ])->default('pending');

            // Approver level 1
            $table->foreignId('approver1_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at_l1')->nullable();
            $table->text('approval_note_l1')->nullable();

            // Approver level 2
            $table->foreignId('approver2_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at_l2')->nullable();
            $table->text('approval_note_l2')->nullable();

            // Rejection
            $table->text('rejection_note')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null');

            // Usage tracking
            $table->integer('start_km')->nullable();
            $table->integer('end_km')->nullable();
            $table->decimal('fuel_used', 8, 2)->nullable();
            $table->text('usage_notes')->nullable();
            $table->timestamp('actual_departure')->nullable();
            $table->timestamp('actual_return')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
