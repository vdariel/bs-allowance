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
        /** @var CompanyModel $company */
        $company = $request->route('company');

        if ($request->route()->hasParameter('company') && (is_null($company) || !$company->active)) {
            abort(404);
        }

        return $next($request);
    }
}
