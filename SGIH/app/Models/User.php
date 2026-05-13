<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'otp_code',
        'otp_expires_at',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'otp_expires_at'      => 'datetime',
            'password'            => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    // --- Role Helpers ---

    public function isRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isSuperAdmin(): bool   { return $this->role === 'superadmin'; }
    public function isDoctor(): bool       { return $this->role === 'doctor'; }
    public function isAccountant(): bool   { return $this->role === 'accountant'; }
    public function isReceptionist(): bool { return $this->role === 'receptionist'; }

    // --- OTP Helpers ---

    /**
     * Check if a given OTP code is valid and not expired.
     */
    public function hasValidOtp(string $code): bool
    {
        return $this->otp_code === $code
            && $this->otp_expires_at
            && $this->otp_expires_at->isFuture();
    }

    /**
     * Generate and save a fresh 6-digit OTP (valid for 24 hours).
     */
    public function generateOtp(): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'otp_code'       => $code,
            'otp_expires_at' => now()->addHours(24),
        ]);
        return $code;
    }

    /**
     * Clear the OTP after successful use.
     */
    public function clearOtp(): void
    {
        $this->update([
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);
    }

    // --- Role-Based Dashboard Route ---

    public function dashboardRoute(): string
    {
        return match($this->role) {
            'superadmin'   => 'superadmin.dashboard',
            'doctor'       => 'doctor.dashboard',
            'accountant'   => 'accountant.dashboard',
            'receptionist' => 'receptionist.dashboard',
            default        => 'dashboard',
        };
    }
}
