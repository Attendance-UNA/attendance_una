<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityGuests extends Model
{
    use HasFactory;
    protected $fillable = ['idActivity','idPerson','entryHour'];
}

