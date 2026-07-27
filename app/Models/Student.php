<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    protected $fillable = [
        'registration_number',
        'secret_code',
        'full_name',
        'email',
        'phone',
        'national_id',
        'faculty_id',
        'gender',
        'birth_date',
        'address',
        'status',
    ];

    protected $hidden = [
        'secret_code',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'secret_code' => 'hashed',
        ];
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function verifySecretCode(string $plain): bool
    {
        return Hash::check($plain, $this->secret_code);
    }

    public static function generateRegistrationNumber(): string
    {
        $prefix = date('Y');
        $last = static::query()
            ->where('registration_number', 'like', $prefix.'%')
            ->orderByDesc('registration_number')
            ->value('registration_number');

        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix.str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    public static function generateSecretCode(): string
    {
        return (string) random_int(100000, 999999);
    }
}
