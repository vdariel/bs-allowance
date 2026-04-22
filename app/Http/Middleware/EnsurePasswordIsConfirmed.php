<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\RequirePassword as BaseRequirePassword;
use Illuminate\Http\Request;

class EnsurePasswordIsConfirmed extends BaseRequirePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  string|null  $redirectToRoute
     * @param  string|int|null  $passwordTimeoutSeconds
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null, $passwordTimeoutSeconds = null)
    {
        if ($this->shouldConfirmPassword($request, $passwordTimeoutSeconds)) {
            if ($request->expectsJson()) {
                return $this->responseFactory->json([
                    'message' => 'Password confirmation required.',
                ], 423);
            }

            $parameters = [];
            if ($request->route()->hasParameter('company')) {
                $parameters['company'] = $request->route('company');
            }

            return $this->responseFactory->redirectGuest(
                $this->urlGenerator->route($redirectToRoute ?: 'password.confirm', $parameters)
            );
        }

        return $next($request);
    }
}
