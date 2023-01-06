<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EMRBirth extends Model
{
    use HasFactory;
    protected $table = 'emr_birth';
    protected $fillable = [
        'bid','hfac_code','birth_no',
        'hfac_label','abandoned','birth_info','PCode','DCode','CCode','babyname',
        'typeofbirth','Atdelivery','dateofbirth','time_of_birth','mothername','motherdofbirth','motherage','fathername','fatherdofbirth','fatherage'
        ,'numofchildalive','medicalid','mPCode','mDCode','mCCode','creation_user','change_user','sex','baby_weight',
        'updated_at','created_at','is_deleted','mVCode','mStreet','mHouse','contact_phone','motherage','fatherage'
    ];
}
