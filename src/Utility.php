<?php

namespace Vugtech\Vugmin;

use Closure;


class Utility{

    public function handle($request, Closure $next)
    {
        if (!Helpmate::sysPass()) {
            return redirect()->route(VugiChugi::acRouter());
        }
        return $next($request);
    }
}
