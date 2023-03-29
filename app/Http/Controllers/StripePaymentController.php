<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function stripe()
  {
    return view('stripe');
  }

  public function __construct()
  {
      // Initialize Stripe library
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
  }

  public function stripePost(Request $request)
  {
      $user = User::find(Auth::id());
      $customer = Customer::where('user_id', $user->id)->first();

      $checkout_session = \Stripe\Checkout\Session::create([
        'customer' => $customer->stripe_customer_id,
          'line_items' => [[ 
              'price' => $request->priceId,
              'quantity' => $request->quantityToBuy,
          ]],
          'mode' => 'payment',
          'success_url' => url()->previous(),
          'cancel_url' => url()->previous(),
      ]);

      return $checkout_session->url;
  }

  public function success(Request $request)
  {
      return view('success');
      //return response()->json(['message' => 'Payment successful']);
  }

  public function cancel(Request $request)
  {
      return view('cancel');
      //return response()->json(['message' => 'Payment canceled']);
  }

  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function stripePostBU(Request $request) {
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    // Get the user model
    $user = User::find(Auth::id());



    Stripe\Charge::create([
      "amount" => 100 * 100,
      "currency" => "usd",
      "customer" => $customer,
      "source" => $request->stripeToken,
      "description" => "Test payment from itsolutionstuff.com."
    ]);


    Session::flash('success', 'Payment successful!');
    return back();
  }
}