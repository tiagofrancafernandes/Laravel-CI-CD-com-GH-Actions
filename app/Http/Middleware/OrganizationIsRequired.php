<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganizationIsRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guest() && Auth::user()?->is_admin) {
            return $next($request);
        }

        if (
            \in_array(
                \Route::currentRouteName(),
                static::bypassRouteNames(),
                \true
            ) ||
            \in_array(
                trim(\parse_url(\URL::current(), PHP_URL_PATH), ' /'),
                array_map(
                    fn ($item) => trim($item, ' /'),
                    static::bypassUri()
                ),
                \true
            )
        ) {
            return $next($request);
        }

        $arrayContains = function (string $currentPath) {
            $currentPath = trim($currentPath, ' /');
            $haystack = \array_filter(
                static::bypassUri(),
                fn ($item) => \str_ends_with($item, '*') || \str_starts_with($item, '*')
            );

            foreach ($haystack as $item) {
                if (\str_ends_with($item, '*') && \str_starts_with($item, '*')) {
                    if (\str_contains($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }

                if (\str_ends_with($item, '*')) {
                    if (\str_starts_with($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }

                if (\str_starts_with($item, '*')) {
                    if (\str_ends_with($currentPath, trim($item, ' /*'))) {
                        return true;
                    }
                }
            }

            return false;
        };

        if ($arrayContains(trim(\parse_url(\URL::current(), PHP_URL_PATH), ' /'))) {
            return $next($request);
        }

        if (\session('org_ref') && Organization::getByOrgRefAndCache(\session('org_ref'))) {
            return $next($request);
        }

        \abort(
            404,
            __('Not found'),
        );
    }

    /**
     * @var array<int, string>
     */
    public static function bypassRouteNames(): array
    {
        return [
            'login',
            'filament.auth.login',
        ];
    }

    /**
     * @var array<int, string>
     */
    public static function bypassUri()
    {
        return [
            '/',
            '/home',
            '*/login',
            '*/register',
            // '*create', // ends with
            // 'create*', // starts with
            // '*create*', // contains
        ];
    }
}
