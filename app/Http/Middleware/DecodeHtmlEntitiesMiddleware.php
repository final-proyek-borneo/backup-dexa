<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DecodeHtmlEntitiesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Mendekode HTML entities di seluruh input data permintaan
         $input = $request->all();
         array_walk_recursive($input, function (&$value) {
             $value = html_entity_decode($value);
         });
         $request->merge($input);
 
         return $next($request);
    }
}
