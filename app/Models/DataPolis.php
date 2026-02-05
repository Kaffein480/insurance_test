<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPolis extends Model
{
    use HasFactory;

    protected $table = "data_polis";

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
