<?php

namespace App\FinoTech\Facade;

class Report extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'report';
    }
}
