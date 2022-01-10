<?php

namespace App\Services\Payment\Providers;

use App\Services\Payment\Contracts\OnlinePayInterface;
use App\Services\Payment\Contracts\ProviderAbstract;

class IDPay extends ProviderAbstract implements OnlinePayInterface
{

    public function pay()
    {
        $params = array(
            'order_id' => ''.$this->request->getOrderID().'',
            'amount' => $this->request->getAmount(),
            'name' => $this->request->getUser()['name'],
            'phone' => $this->request->getUser()['mobile'],
            'mail' => $this->request->getUser()['email'],
            'desc' => $this->request->getDescription(),
            'callback' => route('payment.callback'),
          );

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: '.$this->request->getAPIKey().'',
            'X-SANDBOX: 1'
          ));
          
          $result = curl_exec($ch);
          curl_close($ch);
          $result = json_decode($result, TRUE);

          if (isset($result['error_code']))
            throw new \InvalidArgumentException($result['error_message']);

          return redirect()->away($result['link']);
    }

    public function verify()
    {
        
    }

}