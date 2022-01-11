<?php

namespace App\Services\Payment\Requests;

use App\Services\Payment\Contracts\RequestPayInterface;

class IDPayVerify implements RequestPayInterface
{

    private $id;

    private $orderId ;

    private $APIKey ;
    


    public function __construct(array $data)
    {

        $this->orderId = $data['orderId'];

        $this->APIKey = $data['APIKey'];

        $this->id = $data['id'];
    }


    public function getId()
    {
        return $this->id;
    }

    public function getOrderID()
    {
        return $this->orderId;
    }

    public function getAPIKey()
    {
        return $this->APIKey;
    }

}