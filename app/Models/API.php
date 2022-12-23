<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    use HasFactory;
    protected $table = 'api_users';
    protected $fillable = [
        'api_id','username','api_key','deactivate','created_at','updated_at'
    ];
}
