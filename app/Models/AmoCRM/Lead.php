<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public $incrementing = false;

    public $fillable = [
        'lead_id',
        'contact_id',
        'name',
        'google_client_id',
        'utm_source',
        'utm_campaign',
        'utm_medium',
        'utm_term',
        'utm_content',
        'facebook_client_id',
        'status_id',
        'pipeline_id',
        'revenue',
        'product_name'
    ];
    public $primaryKey = 'lead_id';

}
