<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;

    protected $table = "employees";

    protected $fillable = [
        'full_name',
        'office_id',
        'employment_status',
        'birth_date',
        'civil_status',
        'home_address',
        'contact_number',
        'email_address',
        'facebook_account',
    ];

    
    public function office()
    {
        return $this->belongsTo(OfficeModel::class, 'office_id');
    }
    
    public function dependents()
    {
        return $this->hasMany(DependentModel::class, 'employee_id');
    }
    
    public function records()
    {
        return $this->hasMany(EmployeeRecordModel::class, 'employee_id');
    }
}
