<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    //protected $table = 'users';//Así podríamos crear registros para table Users con tinker desde éste Model
    protected $fillable = ['name', 'description','category'];
}
