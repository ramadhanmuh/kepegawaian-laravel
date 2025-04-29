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
        'id',
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

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
