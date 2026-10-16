<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('email'); // admin, approver
            $table->string('department')->nullable()->after('role');
            $table->string('position')->nullable()->after('department');
            $table->integer('approval_level')->default(0)->after('position'); // 0 = no approval, 1 = level 1, 2 = level 2
            $table->string('phone')->nullable()->after('approval_level');
            $table->boolean('is_active')->default(true)->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'department', 'position', 'approval_level', 'phone', 'is_active']);
        });
    }
};
