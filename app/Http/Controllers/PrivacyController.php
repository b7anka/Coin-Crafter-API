<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PrivacyController extends Controller
{
    public function showPrivacy($lang)
    {
        $languagesAvailable = SharedMethodsController::languagesAvailable();

        if(!in_array($lang, $languagesAvailable))
        {
            $lang = 'en';
            App::setLocale($lang);
        }
        else
        {
            App::setLocale($lang);
        }
        return view('privacy');
    }
}
