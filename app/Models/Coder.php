<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coder extends Model
{
    use HasFactory;
    protected $table = 'coders';
    protected $fillable = [
        'name', 'name_kh','description'
    ];
}
