<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthFacility extends Model
{
    use HasFactory;
    protected $table = 'healthfacility';

    protected $fillable = [
        'HFAC_CODE ','HFAC_Label','HFAC_NAME', 'HFAC_NAMEKh', 'OD_CODE'
    ];
}
