<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id', 'farmer_id', 'weight', 'health_status', 'notes'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function media()
    {
        return $this->hasMany(ReportMedia::class, 'report_id');
    }
}
