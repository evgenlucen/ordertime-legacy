<?php

namespace App\Models\Bizon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    public $fillable = ['_id','name','text','type','nerrors','count1','count2','data','webinarId','mode','created','time_start','time_end','send_to_amo'];

}
