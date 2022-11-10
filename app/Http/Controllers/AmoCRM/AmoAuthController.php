<?php

namespace App\Http\Controllers\AmoCRM;

use App\Services\AmoCRM\ApiClient\Auth;
use Illuminate\Routing\Controller;

class AmoAuthController extends Controller
{
    public function run()
    {
        return Auth::run();
    }
}
