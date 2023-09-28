<?php

namespace App\Http\Middleware\Franchise;

use Closure;
use Log;

class FranchiseAccess {

    public function handle($request, Closure $next) {

        if (auth()->user()->is_team && auth()->user()->role->role_team == 3) {
            return $next($request);
        }

        Log::error("Permiso denegado", ['process' => '[franchises middleware][access]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
