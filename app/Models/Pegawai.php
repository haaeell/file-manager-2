<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'phone_number',
        'address',
        'position',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}