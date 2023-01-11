<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EMRDeath extends Model
{
    use HasFactory;
    protected $table = 'emr_death';
    protected $fillable = [
        'death_id','issue_no',
        'hmis_code','deceased_name','death_info','death_type','deceased_province_code','deceased_district_code','deceased_commune_code',
        'deceased_village','deceased_street','deceased_house','date_of_birth','age','is_baby','sex','medical_file_id','medical_file_id','date_of_death',
        'time_of_death','married_status','created_by','created_at','last_modified_by','update_at',
        'hf_province','hf_district','hf_commune','hf_type','is_deleted','contact_phone'
    ];
}
