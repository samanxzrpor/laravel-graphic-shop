<?php

namespace App\Services\Payment\Contracts;


interface OnlinePayInterface
{

    public function pay();

    
    public function verify();

}