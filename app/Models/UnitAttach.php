<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAttach extends Model
{
    use HasFactory;
    protected $table = 'unit_attach';
    protected $fillable = ['unit_id','user_id','att_type', 'att_file','att_dir','stat','remarks'];

    public function unit()
{
    return $this->belongsTo(Unit::class);
}

public function user()
{
    return $this->belongsTo(User::class); 
}

}
