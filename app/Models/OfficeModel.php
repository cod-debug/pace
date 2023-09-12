<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeModel extends Model
{
    use HasFactory;

    protected $table = "office";

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function employees()
    {
        return $this->hasMany(EmployeeModel::class, 'office_id');
    }
}
