<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitTrail extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'description','details','field','old_value','new_value','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
