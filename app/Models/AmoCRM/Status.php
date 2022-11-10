<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $fillable = ['id','status_id','name','pipeline_id','type','color'];
    public $incrementing = false;

    public function pipeline(){
        return $this->belongsTo(Pipeline::class);
    }
}
