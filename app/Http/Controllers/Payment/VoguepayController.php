<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Api\V2\Seller\SellerPackageController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\WalletController;
use GuzzleHttp\Client;
use App\Models\BusinessSetting;
use Session;
use DB;
use Illuminate\Http\Request;
use Schema;

class VoguepayController extends Controller
{
    public function pay()
    {   
        $paymentType = Session::get('payment_type');

        if ($paymentType == 'cart_payment') {
            return view('frontend.voguepay.cart_payment_vogue');
        } elseif ($paymentType == 'order_re_payment') {
            return view('frontend.voguepay.order_re_payment_vogue');
        } elseif ($paymentType == 'wallet_payment') {
            return view('frontend.voguepay.wallet_payment_vogue');
        } elseif ($paymentType == 'customer_package_payment') {
            return view('frontend.voguepay.customer_package_payment_vogue');
        } elseif ($paymentType == 'seller_package_payment') {
            return view('frontend.voguepay.seller_package_payment_vogue');
        }
    }

    public function paymentSuccess($id)
    {
        if (BusinessSetting::where('type', 'voguepay_sandbox')->first()->value == 1) {
            $url = '//voguepay.com/?v_transaction_id=' . $id . '&type=json&demo=true';
        } else {
            $url = '//voguepay.com/?v_transaction_id=' . $id . '&type=json';
        }
        $client = new Client();
        $response = $client->request('GET', $url);
        $obj = json_decode($response->getBody());

        if ($obj->response_message == 'Approved') {
            $payment_detalis = json_encode($obj);
            // dd($payment_detalis);
            if (Session::has('payment_type')) {
                $paymentType = Session::get('payment_type');
                $paymentData = Session::get('payment_data');

                if ($paymentType == 'cart_payment') {
                    return (new CheckoutController)->checkout_done(Session::get('combined_order_id'), $payment_detalis);
                } elseif ($paymentType == 'order_re_payment') {
                    return (new CheckoutController)->orderRePaymentDone($paymentData, $payment_detalis);
                } elseif ($paymentType == 'wallet_payment') {
                    return (new WalletController)->wallet_payment_done($paymentData, $payment_detalis);
                } elseif ($paymentType == 'customer_package_payment') {
                    return (new CustomerPackageController)->purchase_payment_done($paymentData, $payment_detalis);
                } elseif ($paymentType == 'seller_package_payment') {
                    return (new SellerPackageController)->purchase_payment_done($paymentData, $payment_detalis);
                }
            }
        } else {
            flash(translate('Payment Failed'))->error();
            return redirect()->route('home');
        }
    }

    public function handleCallback(Request $req)
    {
    }

    public function paymentFailure($id)
    {
        flash(translate('Payment Failed'))->error();
        return redirect()->route('home');
    }
}
