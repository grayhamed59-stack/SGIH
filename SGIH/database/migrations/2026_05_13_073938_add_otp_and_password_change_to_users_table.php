<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // OTP fields for first-time login
            $table->string('otp_code', 6)->nullable()->after('password');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');

            // Force password change on first login (after OTP)
            $table->boolean('must_change_password')->default(false)->after('otp_expires_at');

            // Rename 'admin' role conceptually — the column supports 'receptionist'
            // No column change needed, just seeder + middleware update
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_expires_at', 'must_change_password']);
        });
    }
};
