<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAttach extends Model
{
    use HasFactory;

    protected $table = 'unit_attach';

    protected $primaryKey = 'attachment_id'; 
    protected $fillable = [
        'unit_id',
        'file_name',
        'file_type',
        'file_size',
        'att_type',
        'file_remarks', 
        'uploaded_at',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($unit) {
        $unit->unit_id = $unit->unit_id ?? 'UID-' . Str::uuid();
    });
}

}
