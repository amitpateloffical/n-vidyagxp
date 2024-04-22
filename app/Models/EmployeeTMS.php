<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTMS extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employee_tms';
}
