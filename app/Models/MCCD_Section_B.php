<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCCD_Section_B extends Model
{
    use HasFactory;
    protected $table = 'mccd_section_b';
    protected $fillable = [
        'id','mccd_id','question_id','question_name','question_name_kh'
        ,'answer_type_id','setting_type_id','order_no','answer'
        ,'created_by','created_at','update_by','updated_at'
    ];
}
