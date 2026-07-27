<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultSubject extends Model
{
    protected $fillable = [
        'result_id',
        'subject_name',
        'grade',
        'credits',
        'status',
        'sort_order',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }
}
