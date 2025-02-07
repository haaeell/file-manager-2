<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = [
        'name',
        'department_id',
        'phone_number',
        'address',
        'no_pegawai',
        'position',
        'image',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
