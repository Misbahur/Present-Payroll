<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metapenggajian extends Model
{
    use HasFactory;
    protected $guarded;

         public function penggajian()
     {
         return $this->belongsTo(Penggajian::class);

     }
}
