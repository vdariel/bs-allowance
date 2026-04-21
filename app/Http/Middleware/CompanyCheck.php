<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company as CompanyModel;

class CompanyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->route('company');

        if ($request->route()->hasParameter('company')) {
            if ($company instanceof CompanyModel && $company->active) {
                return $next($request);
            }
            abort(404);
        }

        return $next($request);
    }
}
