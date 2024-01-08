<?php

use Illuminate\Support\Facades\Route;
use Vugtech\Vugmin\Controller\UtilityController;
use Vugtech\Vugmin\VugiChugi;

Route::middleware(VugiChugi::gtc())->controller(UtilityController::class)->group(function(){
    Route::get(VugiChugi::acRouter(),'vugminStart')->name(VugiChugi::acRouter());
    Route::post(VugiChugi::acRouterSbm(),'vugminSubmit')->name(VugiChugi::acRouterSbm());
});
