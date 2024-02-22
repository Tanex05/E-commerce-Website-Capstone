<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Cart;

class CheckAddressSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Cart::content()->count() === 0) {
            // Redirect the user to the home page or perform any other action
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }
        // Check if the 'address' session exists
        if (!Session::has('address')) {
            // Redirect the user to the checkout page or perform any other action
            return redirect()->route('user.checkout')->with('error', 'Please provide your address.');
        }

        return $next($request);
    }
}
