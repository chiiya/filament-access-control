<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Middleware;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureAccountIsNotExpired
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() && $request->user()->isExpired() && Feature::enabled(Feature::ACCOUNT_EXPIRY)) {
            auth('filament')->logout();
            $panel ??= Filament::getCurrentPanel()->getId();

            return Redirect::guest(URL::route("filament.{$panel}.account.expired"));
        }

        return $next($request);
    }
}
