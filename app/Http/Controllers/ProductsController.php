<?php

namespace App\Http\Controllers;

use Stripe\Customer;
use App\Models\Orders;
use App\Models\Products;
use Stripe\StripeClient;
use Stripe\Climate\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends Controller
{
    //
    public function index(Request $request)
    {
        // Fetch All Products
        $products = Products::all();

        // Return Products to View 

        return view('products.index', compact('products'));
    }
    public function updateProducts(Request $request, $id)
    {
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        // Add other validation rules based on your product model attributes
    ]);

    // Fetch the product by its ID
    $product = Products::findOrFail($id);

    // Update product details
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->image = $request->input('image');
    // Save the updated product
    $product->save();

    // Redirect to the product listing page with a success message
    return redirect()->route('index')->with('success', 'Product updated successfully.');
    }
    public function edit($id)
    {
    $product = Products::findOrFail($id);
    return view('products.edit', compact('product'));
    }



    public function checkout(Request $request)
    {
        $products = Products::all();
        $lineItems = [];
        $totalPrice = 0;

        foreach ($products as $productDetails) {
            $totalPrice += $productDetails->price;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $productDetails->name,
                    ],
                    'unit_amount' => $productDetails->price * 100,
                ],
                'quantity' => 1,
            ];
        }

        // Initialize Stripe client with secret key
        $stripe = new StripeClient(env("STRIPE_SECRET_KEY"));

        try {
            // Create Stripe checkout session
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}", // Redirect on success Including Session Url
                'cancel_url' => route('checkout.cancel', [], true),   // Redirect on cancel
            ]);

            // Log the checkout session to inspect its content
            Log::info('Checkout Session: ', ['checkout_session' => $checkout_session]);

            // Optionally dump and inspect the checkout session if something is wrong
            // dd($checkout_session); // Uncomment for debugging

            // Create a new order and set it as unpaid
            $order = new Orders();
            $order->status = 'Unpaid';
            $order->total_price = $totalPrice;
            $order->session_id = $checkout_session->id;

            // Save the order
            $order->save();

            // Ensure that the session URL is valid before redirecting
            if (isset($checkout_session->url)) {
                // Redirect to Stripe checkout page
                return redirect($checkout_session->url);
            } else {
                return back()->withErrors('Failed to create Stripe checkout session');
            }
        } catch (\Exception $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return back()->withErrors('Something went wrong with the checkout: ' . $e->getMessage());
        }
    }

    // public function success(Request $request)
    // {
    //     try {
    //         $stripe = new StripeClient(env("STRIPE_SECRET_KEY")); // Stripe API Key
    //         $session_id = $request->get('session_id');
    
    //         // Retrieve session details from Stripe
    //         $session = $stripe->checkout->sessions->retrieve($session_id);
    
    //         if(!$session) {
    //             return redirect()->route('errorPage')->with('error', 'Session not found.');
    //         }
    
    //         // Retrieve order based on session ID
    //         $order = Orders::where('session_id', $session->id)->first();
    
    //         if(!$order) {
    //             return redirect()->route('errorPage')->with('error', 'Order not found.');
    //         }
    
    //         // Update order status if unpaid
    //         if ($order->status === 'unpaid') {
    //             $order->status = 'paid';
    //             $order->save();
    //         }
    
    //         // Retrieve customer information
    //         $customer = $stripe->customers->retrieve($session->customer);
    //         $customer_name = $customer->name ?? 'Valued Customer'; // Fallback if no name found
    
    //         // Take Customer Name to the View
    //         return view('products.success', ['customer' => $customer_name]);
    
    //     } catch (\Exception $e) {
    //         // Log the error and return to an error page
    //         \Log::error('Stripe Session Error: ' . $e->getMessage());
    //         return redirect()->route('errorPage')->with('error', 'An error occurred during the process.');
    //     }
    // }
    public function success(Request $request)
    {
        try {
            $stripe = new StripeClient(env("STRIPE_SECRET_KEY")); // Stripe API Key
            $session_id = $request->get('session_id');
    
            // Retrieve session details from Stripe
            $session = $stripe->checkout->sessions->retrieve($session_id);
    
            if(!$session) {
                return redirect()->route('errorPage')->with('error', 'Session not found.');
            }
    
            // Retrieve order based on session ID
            $order = Orders::where('session_id', $session->id)->first();
    
            if(!$order) {
                return redirect()->route('errorPage')->with('error', 'Order not found.');
            }
    
            // Update order status if unpaid
            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }
    
            // Check if the session has a customer associated
            if ($session->customer) {
                // Retrieve customer information from Stripe if available
                $customer = $stripe->customers->retrieve($session->customer);
                $customer_name = $customer->name ?? 'Valued Customer'; // Fallback if no name found
            } else {
                // Use customer_details from the session object (if available)
                $customer_name = $session->customer_details->name ?? 'Valued Customer'; // Fallback if no name found
            }
    
            // Take Customer Name to the View
            return view('products.success', ['customer' => $customer_name]);
    
        } catch (\Exception $e) {
            \Log::error('Stripe Session Error: ' . $e->getMessage());
            return redirect()->route('errorPage')->with('error', 'An error occurred during the process.');
        }
    }
    

    
     public function cancel()
    {
        
    }
    // Define a webhook Function 

    public function webhook()
    {
        $endpoint_secret = env("STRIPE_WEBHOOK_SECRET");
        $payload = @file_get_contents('php://input');
        $event = null;
        try {
            $event = \Stripe\Event::constructFrom(
              json_decode($payload, true)
            );
          } catch(\UnexpectedValueException $e) {
            // Invalid payload
            echo '⚠️  Webhook error while parsing basic request.';
            http_response_code(400);
            exit();
          }
          if ($endpoint_secret) {
            // Only verify the event if there is an endpoint secret defined
            // Otherwise use the basic decoded event
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
              $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
              );
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
              // Invalid signature
              echo '⚠️  Webhook error while validating signature.';
              http_response_code(400);
              exit();
            }
          }
          // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
            // Then define and call a method to handle the successful payment intent.
            // handlePaymentIntentSucceeded($paymentIntent);
            break;
            case 'payment_method.attached':
            $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
            // Then define and call a method to handle the successful attachment of a PaymentMethod.
            // handlePaymentMethodAttached($paymentMethod);
            break;
            default:
            // Unexpected event type
            error_log('Received unknown event type');
        }
        http_response_code(200);
    }

}
