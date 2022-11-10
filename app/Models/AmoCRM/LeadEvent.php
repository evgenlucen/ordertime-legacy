<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class LeadEvent
 * @package App\Models\AmoCRM
 * @mixin Builder
 */
class LeadEvent extends Model
{
    use HasFactory;

    public $fillable = ['lead_id','event_name'];

}
