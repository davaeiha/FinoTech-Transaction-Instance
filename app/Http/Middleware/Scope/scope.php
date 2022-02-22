<?php

namespace App\Http\Middleware\Scope;

use App\Exceptions\Scope\InvalidScopeException;
use App\Exceptions\Scope\UnauthorizedScopeException;
use Closure;
use Illuminate\Http\Request;

class scope
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws InvalidScopeException
     * @throws UnauthorizedScopeException
     */
    public function handle(Request $request, Closure $next,$scope)
    {

        if (! $request->user() || ! $request->user()->finotech_token) {
            throw new UnauthorizedScopeException();
        }

        foreach($request->user()->scopes as $userScope){
            if ($scope !== $userScope){
                throw new InvalidScopeException();
            }
        }

        return $next($request);
    }
}
