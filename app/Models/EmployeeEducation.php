<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_education';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'employee_id',
        'level',
        'school_name',
        'school_address',
        'major',
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
