<?php

namespace App\Services\Payment\Contracts;

abstract class ProviderAbstract
{

    public function __construct(protected RequestPayInterface $request)
    {
        
    }

}