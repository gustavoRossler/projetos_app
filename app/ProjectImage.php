<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $table = "projects_images";

    protected $fillable = [
        'project_id', 'file', 'main'
    ];
}
