<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'customers';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'address_line',
        'postal_code',
        'city',
        'state',
        'country',
        'stripe_customer_id',
        // Add created_by and updated_by to fillable attributes
        'created_by',
        'updated_by'
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
