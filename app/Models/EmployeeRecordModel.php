<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRecordModel extends Model
{
    use HasFactory;

    protected $table = "employee_record";

    protected $fillable = [
        "employee_id",
        "payment_date",
        "particulars",
        "union_dues",
        "ip_funds",
        "fa",
        "notes",
        "status"
    ];

    public function employee(){
        return $this->belongsTo(EmployeeModel::class, 'employee_id')->with('office');
    }
}
