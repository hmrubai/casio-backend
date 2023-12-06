<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsdList extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "dealer_name",
        "distributor_name",
        "division",
        "asm_rsm_name",
        "outlet_address",
        "contact_person",
        "contact_no",
        "latitude",
        "longitude",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
