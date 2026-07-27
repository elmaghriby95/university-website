<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year',
        'semester',
        'gpa',
        'notes',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'gpa' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(ResultSubject::class)->orderBy('sort_order');
    }
}
