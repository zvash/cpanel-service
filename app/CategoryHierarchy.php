<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryHierarchy extends TaskFeed
{
    protected $table = 'category_hierarchies';

    protected $fillable = ['parent_id', 'child_id'];
}
