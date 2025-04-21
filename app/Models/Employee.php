<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'number',
        'designation_id',
        'email',
        'phone',
        'gender',
        'religion',
        'place_of_birth',
        'date_of_birth',
        'date_of_joining',
        'marital_status',
        'photo',
        'address',
    ];
}
