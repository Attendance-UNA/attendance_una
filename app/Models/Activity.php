<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "date",
        "startTime",
        "endTime",
        "description",
        "manager",
        "subcategories",
        "status"  # 1Ready to start 0End, can not start 
    ];

}
