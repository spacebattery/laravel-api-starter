<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    use Filterable, Sortable;

    protected $fillable = ['name'];
}
