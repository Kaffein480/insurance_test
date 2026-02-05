<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataInvoice extends Model
{
    use HasFactory;

    protected $table = "data_invoice";

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function polis()
    {
        return $this->belongsTo(DataPolis::class, 'polis_id');
    }
}
