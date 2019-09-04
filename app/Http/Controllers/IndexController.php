<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function index($lang)
    {
        $languagesAvailable = SharedMethodsController::languagesAvailable();

        if(!in_array($lang, $languagesAvailable))
        {
            $lang = 'en';
            return redirect('/'.$lang);
        }
        else
        {
            App::setLocale($lang);
            return view('welcome');
        }
    }

    public function indexNoLanguageDefined(Request $request)
    {
        $langAccepted = $request->server('HTTP_ACCEPT_LANGUAGE');
        $langToUseArray = explode(',',$langAccepted);
        if(strpos($langToUseArray[0],'-') > -1)
        {
            $locale = explode('-',$langToUseArray[0])[0];
        }
        else
        {
            $locale = explode(';',$langToUseArray[0])[0];
        }
        return redirect('/'.$locale);
    }

    public function verifyTransaction(Request $request){

        $success = false;
        $error = 401;

        $device = $request->device;
        
        if(empty($device)){
            $error = 403;
        }else {
            if($device == 'android'){
                $signed_data = $request->signed_data;
                $signature = $request->signature;
                if(empty($signed_data) || empty($signature)){
                    $error = 402;
                }else {
                    $error = 0;
                    $success = $this->verifyInAppPlayStore($signed_data, $signature);
                }
            }else {
                $receipt = $request->receiptIOS;
                $is_sandbox = (bool)$request->is_sandbox;
                if(empty($receipt) || empty($is_sandbox)){
                    $error = 402;
                }else {
                    $error = 0;
                    $success = $this->verifyInAppAppStore($receipt, $is_sandbox);
                }
            }
        }

        return json_encode([
            'success' => $success,
            'error' => $error
        ]);
    }

    private function verifyInAppPlayStore($signed_data, $signature){

        define("PUBLIC_KEY","YOU_APP_PUBLIC_KEY");
        
        $key =	"-----BEGIN PUBLIC KEY-----\n".
        chunk_split(PUBLIC_KEY, 64,"\n").
        '-----END PUBLIC KEY-----';   
    
        $key = openssl_get_publickey($key);
    
        $signature = base64_decode($signature);   
    
        $result = openssl_verify(
                $signed_data,
                $signature,
                $key,
                OPENSSL_ALGO_SHA1);
        if (0 === $result) 
        {
            return false;
        }
        else if (1 !== $result)
        {
            return false;
        }
        else 
        {
            return true;
        }
        
    }

    private function verifyInAppAppStore($receipt, $is_sandbox)
    {
        if ($is_sandbox)
            $verify_host = "ssl://sandbox.itunes.apple.com";
        else
            $verify_host = "ssl://buy.itunes.apple.com";

        $json='{"receipt-data" : "'.$receipt.'" }';

        $fp = fsockopen ($verify_host, 443, $errno, $errstr, 30);
        if (!$fp)
        {
            return false;
        }
        else
        {
            $header = "POST /verifyReceipt HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($json) . "\r\n\r\n";
            fputs ($fp, $header . $json);
            $res = '';
            while (!feof($fp))
            {
                $step_res = fgets ($fp, 1024);
                $res = $res . $step_res;
            }
            fclose ($fp);

            $json_source = substr($res, stripos($res, "\r\n\r\n{") + 4);

            $app_store_response_map = json_decode($json_source);
            $app_store_response_status = $app_store_response_map->{'status'};
            if ($app_store_response_status == 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
