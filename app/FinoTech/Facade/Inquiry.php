<?php

namespace App\FinoTech\Facade;

use Illuminate\Support\Facades\Facade;

class Inquiry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inquiry';
    }
}
