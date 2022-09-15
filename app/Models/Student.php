<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'identification_no', 'country', 'date_of_birth', 'registered_on'];

    protected $hidden = ['created_at', 'updated_at'];
}
