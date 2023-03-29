<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    // Define the table name
    protected $table = 'packages';

    // Define the fillable attributes
    protected $fillable = [
        'package_name',
        'price',
        'type',
        'number_of_students',
        'validity_duration',
        'is_active',
        // Add created_by and updated_by to fillable attributes
        'created_by',
        'updated_by'
    ];

    // Define the casts for attributes
    protected $casts = [
        'price' => 'double',
        'number_of_students' => 'integer',
        'validity_duration' => 'integer',
        'is_active' => 'boolean'
    ];

    // Define the relationships with users table
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}