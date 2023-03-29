<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;
use Stripe;

class SubscriptionController extends Controller
{
    /**
     * List the subscriptions for user.
     */
    public function list(Request $request): View
    {

        $packages = Package::all()->toArray();

        return view('subscription.view', [
            'user' => $request->user(), 'packages' => $packages
        ]);
    }

    /**
     * List the subscriptions for user.
     */
    public function storeCustomer(Request $request): RedirectResponse
    {
        // dd($request);

        // Get the user model
        $user = User::find(Auth::id());

        $newCustomer = new Customer($request->all());
        $newCustomer->save();

        $newCustomer->user_id = $user->id;
        $newCustomer->address_line = $request->line1;
        $newCustomer->postal_code = $request->postal_code;
        $newCustomer->city = $request->city;
        $newCustomer->state = $request->state;
        $newCustomer->country = $request->country;

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripeCustomer = \Stripe\Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            "address" => [
                    "line1" => $request->line1,
                    "postal_code" => $request->postal_code,
                    "city" => $request->city,
                    "state" => $request->state,
                    "country" => $request->country,
                  ],
                  "source" => $request->stripeToken
        ]);

        $newCustomer->stripe_customer_id = $stripeCustomer->id;
        $newCustomer->save();

        Session::flash('success', 'Payment successful!');
        return back();

        // return view('subscription.view', [
        //     'user' => $request->user(), 'packages' => $packages
        // ]);
    }
}


    // $customer = Stripe\Customer::create(array(
    //   "address" => [
    //     "line1" => "Virani Chowk",
    //     "postal_code" => "360001",
    //     "city" => "Rajkot",
    //     "state" => "GJ",
    //     "country" => "IN",
    //   ],
    //   "email" => "demo@gmail.com",
    //   "name" => "Hardik Savani",
    //   "source" => $request->stripeToken
    // ));
