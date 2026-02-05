<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataOkupasi extends Model
{


    protected $table = "data_okupasi";

    protected $fillable = [
        'nama_okupasi',
        'premi'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
