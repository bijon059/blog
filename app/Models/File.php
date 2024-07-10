<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @param
 */
class File extends Model
{
    protected $fillable = [
        'image_url',
        'file_type',
        'uploaded_by',
        'post_id',
    ];
}
