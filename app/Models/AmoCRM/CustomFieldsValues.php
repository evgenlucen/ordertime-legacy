<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldsValues extends Model
{
    use HasFactory;

    public function custom_field()
    {
        return $this->hasOne(CustomField::class);
    }
}
