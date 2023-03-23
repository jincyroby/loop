<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
	protected $fillable = [
        'job_title',
        'email_address',
		'name',
		'registered_since',
		'phone',
    ];
}
