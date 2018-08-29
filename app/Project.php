<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'description', 'notes', 'area', 'project_architect_price', 'project_engineer_price', 
        'project_final_price', 'construction_price', 'user_id', 'active'
    ];

    public function images()
    {
        return $this->hasMany('\App\ProjectImage', 'project_id', 'id')->orderBy('main', 'desc');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
