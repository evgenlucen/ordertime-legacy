<?php

namespace App\Models\AmoCRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class CustomField extends Model
{
    use HasFactory;
    public $incrementing = false;

    public function enums()
    {
        return $this->hasMany(Enum::class);
    }
}
