<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pola extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jam_masuk', 'jam_istirahat', 'jam_istirahat_masuk', 'jam_pulang'];
}
