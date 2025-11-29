<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMedia extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'type', 'url'];

    public function report()
    {
        return $this->belongsTo(FarmerReport::class, 'report_id');
    }
}
