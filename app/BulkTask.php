<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulkTask extends Model
{
    protected $fillable = [
        'description',
        'csv_file',
        'images_zip_file',
        'is_activated',
        'status',
        'result'
    ];
}
