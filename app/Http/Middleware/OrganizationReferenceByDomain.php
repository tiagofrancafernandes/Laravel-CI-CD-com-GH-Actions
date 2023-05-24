<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizationReferenceByDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = trim($request->getHost());
        $mainDomain = trim(config('app-sets.main_domain'));

        if ($host === $mainDomain) {
            return $next($request);
        }

        $organizationReference = explode(".{$mainDomain}", $host, 2)[0] ?? \null;
        $organization = $organizationReference ? Organization::getByOrgRefAndCache($organizationReference) : \null;

        if ($organization && $organization?->org_ref) {
            \session()->put('org_ref', $organization?->org_ref);
        }

        return $next($request);
    }
}
