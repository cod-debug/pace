<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependentModel extends Model
{
    use HasFactory;
    protected $table = "dependent";

    protected $fillable = [
        'employee_id',
        'name',
        'birth_date',
        'relationship',
        'status',
    ];
}
