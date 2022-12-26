<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'medical_questions';
    protected $fillable = [
        'id','section_id','question','question_kh','answer_type','setting_type_id','order_no','created_at','updated_at'
    ];
}
