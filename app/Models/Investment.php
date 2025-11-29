<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'units', 'amount', 'status', 'transaction_id'];

    public function investor(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
