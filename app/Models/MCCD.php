<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCCD extends Model
{
    use HasFactory;
    protected $table = 'mccd';
    protected $fillable = [
        'mccd_id','issue_no',
        'death_id','created_by','created_at','updated_by','updated_at'
    ];
}
