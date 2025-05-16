<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'termination_type_id',
        'employee_id',
        'subject',
        'notice_date',
        'termination_date',
        'description',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
