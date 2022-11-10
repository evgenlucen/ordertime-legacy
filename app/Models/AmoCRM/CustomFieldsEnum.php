<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldsEnum extends Model
{
    use HasFactory;
    public $incrementing = false;

    public function custom_field()
    {
        return $this->hasOne(CustomField::class);
    }
}
