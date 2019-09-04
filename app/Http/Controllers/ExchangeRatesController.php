<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExchangeRate;
use App\LatestRates;
use App\Rate;

class ExchangeRatesController extends Controller
{
    public function getLatestExchangeRates($lang){


        $languagesAvailable = app(SharedMethodsController::class)->languagesAvailable();

        if(!in_array($lang, $languagesAvailable))
        {
            $lang = 'en';
            return redirect('/api/latest/'.$lang);
        }
        else {
            $rates = [];
            $allExchanges = ($lang == 'en' ? ExchangeRate::orderBy('name_en', 'ASC')->get() : ExchangeRate::orderBy('name_pt', 'ASC')->get());

            foreach($allExchanges as $exchange){

                $rate = new Rate();
                $rate->code = $exchange->currency;
                $rate->value = $exchange->value;
                $rate->name = [
                    "en" => $exchange->name_en,
                    "pt" => $exchange->name_pt,
                ];
                $rate->symbol = $exchange->symbol;
                $rate->all_currencies = 1;
                $rate->most_valuable = $exchange->most_valuable;
                $rate->crypto = $exchange->crypto;
                $rate->most_traded = $exchange->most_traded;
                $rate->img = $exchange->img;            
                array_push($rates, $rate);
            }

            $latestRates = new LatestRates();
            $latestRates->success = true;
            $latestRates->date = date("Y-m-d");
            $latestRates->baseCoin = "EUR";
            $latestRates->type = "online";
            $latestRates->rates = $rates;

            return json_encode($latestRates);
            }
        
    }
}
