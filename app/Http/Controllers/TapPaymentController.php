<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Karim007\LaravelTap\Facade\TapPayment;

class TapPaymentController extends Controller
{
    public function pay()
    {
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer sk_test_t9RPdDs15lYAnoITN7GVuLFi',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api.tap.company/v2/charges', [
                'amount' => 100,
                'currency' => 'KWD',
                'customer_initiated' => true,
                'threeDSecure' => true,
                'save_card' => false,
                'description' => 'Test Description',
                'metadata' => [
                    'udf1' => 'Metadata 1',
                ],
                'reference' => [
                    'transaction' => 'txn_01',
                    'order' => 'ord_01',
                ],
                'receipt' => [
                    'email' => true,
                    'sms' => true,
                ],
                'customer' => [
                    'first_name' => 'Mohamed',
                    'middle_name' => 'Gaber',
                    'last_name' => 'Meabed',
                    'email' => 's@s.com',
                    'phone' => [
                        'country_code' => 02,
                        'number' => 1017205578,
                    ],
                ],
                'source' => [
                    'id' => 'src_card',
                ],
                'post' => [
                    'url' => 'https://webhook.site/1f1b11e3-a99e-4a26-9520-feb8b615baa3',
                ],
                'redirect' => [
                    'url' => route('payment.callback'),
                ],
            ]);
//            dd($response->json());
            return view('payment', ['url' => $response->json()['transaction']['url']]);

        }catch(\Exception $e){
            dd($e);
        }
    }

    public function callback(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer sk_test_48FQTBNfpmixca2zDHZMuPdn',
            'Accept' => 'application/json',
        ])->get('https://api.tap.company/v2/charges/'.$request->tap_id);


        if( $response->json()['status'] == 'CAPTURED'){
            return to_route('dashboard')->with(['success' => 'Order Plased Successfully']);
        }
        return to_route('dashboard')->with(['error' => 'Error ocur']);
    }

    public function form()
    {
        return view('payment');
    }
}
