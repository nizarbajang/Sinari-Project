<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'farmer_id', 'admin_id', 'title', 'description', 'animal_type', 'price_per_unit',
        'total_units', 'sold_units', 'duration_months', 'profit_percentage', 'status',
    ];

    public function farmer(){
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

     public function media()
    {
        return $this->hasMany(ProjectMedia::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function reports()
    {
        return $this->hasMany(FarmerReport::class);
    }
}
