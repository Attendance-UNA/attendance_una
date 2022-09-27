<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "firstLastName",
        "secondLastName",
        "email",
        "category",
        "subcategories",
        "status",
        "institutionalCard",
        "phone"
    ];
}
