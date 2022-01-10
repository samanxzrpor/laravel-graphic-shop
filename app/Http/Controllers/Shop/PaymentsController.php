<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\User\StoreUser;
use App\Models\Payment as ModelsPayment;
use App\Models\Product;
use App\Models\User;
use App\Services\Payment\Payment;
use App\Services\Payment\Requests\IDPayRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{

    public function pay(StoreUser $request)
    {
        try {

            if (count(Cart::showAll()) <= 0)
                throw new \InvalidArgumentException('سبد خرید شما خالی میباشد');

            $user  = $this->getUser($request);

            $order = $this->getOrder($user);

            if (isset($request->provider) && $request->provider == 'IDPAY')
                $provider = Payment::IDPAY;

            if (isset($request->ZarinpalPay) && $request->provider == 'ZARINPAL')
                $provider = Payment::ZARINPAL;

            $ref_code = rand(10000 , 999999);

            $StoredPayment = ModelsPayment::create([
                'ref_code' => $ref_code,
                'res_code' => $ref_code,
                'order_id' => $order->id,
                'geteway' => strtolower($provider)
            ]);
        
            $payRequest = new IDPayRequest([
                'user' => $user->name,
                'amount'=> $this->getOrderPrice(),
                'mobile'=> $user->number,
                'email'=> $user->email,
                'orderId' => $order->id,
                'description' => 'پرداخت',
                'APIKey' => $this->getAPIKey($provider)
            ]);
    
            $payment = new Payment($provider , $payRequest);
            return $payment->pay();

        } catch (\Exception $e) {
            return back()->with('failed' , $e->getMessage());
        }

    }

    public function callback()
    {
        
    }

    public function getOrderPrice()
    {
        $itemsKey = array_keys(Cart::showAll()); 

        $products = Product::findMany($itemsKey);

        return $products->sum('price');
    }

    public function getAPIKey(string $provider)
    {
        foreach (config('services.getwayes') as $myProvider => $data) {

            if ($provider == $myProvider)
                return $data['APIKey'];
        }
    }

    private function getUser($request)
    {
        $userForStore = $request->validated();

        $user = User::firstOrCreate(['email' => $userForStore['email']], [
            'number' => $userForStore['mobile'],
            'password' => Hash::make($userForStore['password']),
            'name' => $userForStore['name']
        ]);

        return $user;
    }

    public function getOrder(array|object $user)
    {
        $order = Orders::createOrder([
            'amount' => Cart::getAmountCart(),
            'user_id' => $user->id,
            'ref_code' => Str::random(30)
        ]);

        $this->getOrderItems($order->id);

        return $order;
    }

    public function getOrderItems(int $orderId)
    {
        OrderItems::storeOrderItems(Cart::showAll() , $orderId);
    }
}
