<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    use HasFactory;

    public $fillable = ['id','name', 'is_main'];
    public $incrementing = false;

    public function statuses(){
        return $this->hasMany(Status::class);
    }
}
