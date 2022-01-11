<?php
namespace App\Services\Payment;

use App\Services\Payment\Contracts\RequestPayInterface;
use App\Services\Payment\Exceptions\NotFoundProviderException;

class Payment 
{
    public const IDPAY = 'IDPay';

    public const ZARINPAL = 'ZarinpalPay';

    private $providerType ;

    private $request;

    public function __construct(string $type , RequestPayInterface $request)
    {
        $this->providerType = $type;

        $this->request = $request;
    }

    public function pay()
    {
        return $this->findProvider()->pay();
    }

    public function verify()
    {
        return $this->findProvider()->verify();
    }


    public function findProvider()
    {
        $providerClass = 'App\Services\Payment\Providers\\' . $this->providerType;

        if (!class_exists($providerClass))
            throw new NotFoundProviderException('درگاه پرداخت انتخاب شده یافت نشد');

        return new $providerClass($this->request);
    }

}