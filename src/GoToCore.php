<?php

namespace Vugtech\Vugmin;

use App\Models\GeneralSetting;
use Closure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class GoToCore{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle($request, Closure $next)
    {
        $fileExists = file_exists(__DIR__.'/vugmin.json');
        $general = $this->getGeneral();
        if ($fileExists && $general->maintenance_mode != 9 && env('PURCHASECODE')) {
            return redirect()->route(VugiChugi::acDRouter());
        }
        return $next($request);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getGeneral(){
        $general = cache()->get('GeneralSetting');
        if (!$general) {
            $general = GeneralSetting::first();
        }
        return $general;
    }
}
