<?php

namespace Vugtech\Vugmin\Controller;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Vugtech\Vugmin\Helpmate;
use Vugtech\Vugmin\VugiChugi;

class UtilityController extends Controller{

    public function vugminStart()
    {
        $pageTitle = VugiChugi::lsTitle();
        return view('Vugmin::vugmin_start',compact('pageTitle'));
    }

    public function vugminSubmit(Request $request){
        Artisan::call('cache:clear');
        $param['code'] = $request->purchase_code;
        $param['url'] = Helpmate::siteUrl();
        $param['user'] = $request->envato_username;
        $param['email'] = $request->email;
        $param['ip'] = $request->ip();
        $param['product'] = systemDetails()['name'];
        $reqRoute = VugiChugi::lcLabSbm();
        $response = CurlRequest::curlPostContent($reqRoute, $param);
        $response = json_decode($response);

        if ($response->error == 'error' || $response->error == 'errors') {
            return response()->json(['type'=>'error','message'=>$response->message]);
        }

        $env = $_ENV;
        $env['PURCHASECODE'] = $request->purchase_code;
        $envString = '';
        foreach($env as $k => $en){
            $envString .= $k.'='.$en.'
';
        }

        $envLocation = base_path().$response->location;

        $envFile = fopen($envLocation, "w");
        fwrite($envFile, $envString);
        fclose($envFile);

        $txt = '{
    "purchase_code":'.'"'.$request->purchase_code.'",'.'
    "installcode":'.'"'.@$response->installcode.'",'.'
    "license_type":'.'"'.@$response->license_type.'"'.'
}';
        file_put_contents(dirname(__DIR__).'/vugmin.json',$txt);

        file_put_contents(dirname(__DIR__, 1).'/.vugtech', file_get_contents($envLocation));
        $newApp = file_get_contents(dirname(__DIR__, 1).'/bootstrap/app.php');
        file_put_contents(base_path().'/bootstrap/app.php',$newApp);

        $general = GeneralSetting::first();
        $general->maintenance_mode = 0;
        $general->save();

        return response()->json(['type'=>'success']);

    }
}
