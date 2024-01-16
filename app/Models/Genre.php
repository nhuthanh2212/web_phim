<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;
    use HasFactory;
     protected $table='genres';
    
    protected $fillable=['title','status','description','slug','position'];
    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
