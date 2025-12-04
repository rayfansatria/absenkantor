<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'name',
        'code',
        'description',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
