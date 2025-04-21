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
        'termination_type_id',
        'employee_id',
        'subject',
        'notice_date',
        'termination_date',
        'description',
    ];
}
