<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCCD_Section_A extends Model
{
    use HasFactory;
    protected $table = 'mccd_section_a';
    protected $fillable = [
        'id','mccd_id','order_no','death_reason','period','level_coder','created_by','created_at','update_by','updated_at'
    ];
}
