<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe;

class PackagesController extends Controller
{
    // Store function to create a new package
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.0',
            'type' => 'required|in:subscription,wallet',
            'number_of_students' => 'required|integer|min:1',
            'validity_duration' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            // Add validation rules for created_by and updated_by
            // Use exists rule to check if the user id exists in the users table
            'created_by' => 'required|exists:users,id',
            'updated_by' => 'required|exists:users,id'
        ]);

        // If validation fails, redirect back with errors and old input
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed. Please review the form.', 'errors' => $validator->errors()->toArray()], 422);
            // return redirect()->back()->withErrors($validator)->withInput();
        }


        // Create a new package instance with the request data
        $package = new Package($request->all());

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $product = Stripe\Product::create([
            'name' => $request->package_name,
            // TODO Add description 
            'description' => $request->package_name,
        ]);

        // "id" => "prod_NTbOBq63GwQCKg"
        // "object" => "product"
        // "active" => true
        // "attributes" => []
        // "created" => 1678109690
        // "default_price" => null
        // "description" => "Monthly Ed Package"
        // "images" => []
        // "livemode" => false
        // "metadata" => []
        // "name" => "Monthly Ed Package"
        // "package_dimensions" => null
        // "shippable" => null
        // "statement_descriptor" => null
        // "tax_code" => null
        // "type" => "service"
        // "unit_label" => null
        // "updated" => 1678109690
        // "url" => null
        
        $stripePrice = Stripe\Price::create([
            "product" => $product->id,
            "unit_amount" => $request->price * 100,
            "currency" => 'usd',
            "source" => $request->stripeToken,
        ]);

        // "id" => "price_1MieCVDSkpt1CrdfTzFZgWub"
        // "object" => "price"
        // "active" => true
        // "billing_scheme" => "per_unit"
        // "created" => 1678109739
        // "currency" => "usd"
        // "custom_unit_amount" => null
        // "livemode" => false
        // "lookup_key" => null
        // "metadata" => []
        // "nickname" => null
        // "product" => "prod_NTbP9kHa7VXLtN"
        // "recurring" => null
        // "tax_behavior" => "unspecified"
        // "tiers_mode" => null
        // "transform_quantity" => null
        // "type" => "one_time"
        // "unit_amount" => 123
        // "unit_amount_decimal" => "123"

        $package->stripe_price_id = $stripePrice->id;
        $package->published_stripe = true;

        // Save the package to the database
        $package->save();

        return response()->json(['success' => true, 'message' => 'Successfully saved package.', 'data' => $package]);

        // Redirect to the packages index page with a success message
        return redirect()->route('subscriptions')->with('success', 'Package created successfully.');
    }
}
