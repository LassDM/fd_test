<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateApi extends Middleware
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        $token = $request->query('api_token');
        if (empty($token)) {
            $token = $request->header('api_token');
        }
        if (empty($token)) {
            $token = $request->input('api_token');
        }
        if (empty($token)) {
            $token = $request->bearerToken();
        }

        if ($token === config('apitokens.api_token')) return;
        $this->unauthenticated($request, $guards);
    }
}
