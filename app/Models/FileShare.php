<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileShare extends Model
{
    use HasFactory;

    protected $table = 'file_share';
    protected $fillable = ['file_id', 'folder_id', 'shared_with_id', 'permission'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with_id');
    }
}
