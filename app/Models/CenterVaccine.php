<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterVaccine extends Model
{
    use HasFactory;

    protected $table = "center_has_vaccines";

    public $timestamps = false;
}
