<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'name',
        'date',
        'type',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
