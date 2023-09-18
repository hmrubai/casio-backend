<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        "store_name",
        "store_name_bn",
        "store_email",
        "store_contact_no",
        "store_address",
        "store_trade_license",
        "store_lat",
        "store_long",
        "district_id",
        "division_id",
        "thana_id",
        "area_id",
        "owner_name",
        "owner_email",
        "owner_contact_no",
        "owner_nid",
        "rating",
        "sequence",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
