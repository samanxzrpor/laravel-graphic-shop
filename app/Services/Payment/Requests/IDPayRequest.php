<?php

namespace App\Services\Payment\Requests;

use App\Services\Payment\Contracts\RequestPayInterface;

class IDPayRequest implements RequestPayInterface
{

    private $user;

    private $amount ;

    private $orderId ;

    private $APIKey ;

    private $description ;


    public function __construct(array $data)
    {
        $this->user = [
            'name' => $data['user'],
            'mobile' => $data['mobile'],
            'email' => $data['email']
        ];

        $this->amount = $data['amount'];

        $this->orderId = $data['orderId'];

        $this->APIKey = $data['APIKey'];

        $this->description = $data['description'];
    }


    public function getUser()
    {
        return $this->user;
    }


    public function getAmount()
    {
        return $this->amount * 10;
    }

    public function getOrderID()
    {
        return $this->orderId;
    }

    public function getAPIKey()
    {
        return $this->APIKey;
    }

    public function getDescription()
    {
        return $this->description;
    }

}