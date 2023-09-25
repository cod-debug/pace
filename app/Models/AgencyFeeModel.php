<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyFeeModel extends Model
{
    use HasFactory;
    protected $table = "agency_fee";

    protected $fillable = [
        "full_name",
        "payment_date",
        "particulars",
        "union_dues",
        "ip_funds",
        "fa",
        "notes",
        "status"
    ];
}
