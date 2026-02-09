<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isSeller()) {
            abort(403);
        }
        $seller = auth()->user()->seller;
        if (!$seller || $seller->status !== 'approved') {
            return redirect()->route('seller.pending');
        }
        return $next($request);
    }
}
