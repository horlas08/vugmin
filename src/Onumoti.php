<?php

namespace Vugtech\Vugmin;

use App\Lib\CurlRequest;
use App\Models\GeneralSetting;


class Onumoti{

    public static function getData(){
        $param['purchasecode'] = env("PURCHASECODE");
        $param['website'] =  Helpmate::siteUrl();
        $reqRoute = VugiChugi::lcLabRoute();
        $reqRoute = $reqRoute. systemDetails()['name'];
        $response = CurlRequest::curlPostContent($reqRoute, $param);

        $response = json_decode($response);
        $general = GeneralSetting::first();
        if (@$response->mm) {
            $general->maintenance_mode = $response->mm;
            $general->save();
        }
        if (@$response->revert) {
            // TODO
            $general->maintenance_mode = $response->mm;
            $general->save();
        }
        $push = [];
        if (@$response->version && (@systemDetails()['version'] < @$response->version)) {
            $push['version'] = @$response->version ?? '';
            $push['details'] = @$response->details ?? [];
        }

        if (@$response->message) {
            $push['message'] = @$response->message ?? [];
            $push['message_till'] = @$response->message_till ?? now();
        }
        $general->system_info = $push;
        $general->save();
    }

    public static function mySite($site,$className){
        $myClass = VugiChugi::clsNm();
        if($myClass != $className){
            return $site->middleware(VugiChugi::mdNm());
        }
    }
}
