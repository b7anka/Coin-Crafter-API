<?php

/*
    Run this script as a cron job (linux/macOS) or as a scheduled task (windows) once per hour in a total of 24
    times a day to avoid reaching the api limits for a free api key. And then use the laravel api route to give 
    your app the latest exchange rates from your own database
*/

$con = mysqli_connect("YOUR_DB_SERVER_URL","YOUR_DB_USERNAME","YOUR_DB_PASSWORD","YOUR_SCHEMA");
    if (!$con) {
        echo "Connection error: " . mysqli_connect_errno() . " - " . mysqli_connect_error();
        exit();
    }

    mysqli_set_charset($con, "utf8");

$euroName = 'EUR';
$bitcoinName = 'BTC';
$litecoinName = 'LTC';
$zcashName = 'ZEC';
$dashName = 'DASH';
$rippleName = 'XRP';
$moneroName = 'XMR';
$eosName = 'EOS';
$cardanoName = 'ADA';
$ethereumName = 'ETH';
$neoName = 'NEO';

$date = date("Y-m-d H:i:s");

$exchangeRatesForCurrencyUrl = 'http://data.fixer.io/api/latest?access_key=YOUR_ACCESS_KEY_HERE';
$exchangeRatesForCurrencyData = getData($exchangeRatesForCurrencyUrl, true);
$arrayValues = array_values($exchangeRatesForCurrencyData["rates"]);
$arraykeys = array_keys($exchangeRatesForCurrencyData["rates"]);

$arrayOfBadValues = [$euroName, $bitcoinName, "CLF", "BYR", "LVL", "NLG", "ZWK", "ZWL", "XDR", "STD", "MRO", "LTL"];

for($j = 0; $j < count($arrayValues); $j++){
        if(in_array($arraykeys[$j], $arrayOfBadValues)){
            continue;
        }else {
            saveData($arraykeys[$j], $arrayValues[$j]);
        }
}

$bitcoinUrl = makeUrlForCryptoCurrencies($bitcoinName);
$bitcoinData = getData($bitcoinUrl, false);
$bitcoin = $bitcoinData->ticker->price;
saveData($bitcoinName, $bitcoin);

$litecoinURL = makeUrlForCryptoCurrencies($litecoinName);
$litcoinData = getData($litecoinURL, false);
$litcoin = $litcoinData->ticker->price;
saveData($litecoinName, $litcoin);

$ethereumURL = makeUrlForCryptoCurrencies($ethereumName);
$ethereumData = getData($ethereumURL, false);
$ethereum = $ethereumData->ticker->price;
saveData($ethereumName, $ethereum);

$zcashURL = makeUrlForCryptoCurrencies($zcashName);
$zcashData = getData($zcashURL, false);
$zcash = $zcashData->ticker->price;
saveData($zcashName, $zcash);

$rippleURL = makeUrlForCryptoCurrencies($rippleName);
$rippleData = getData($rippleURL, false);
$ripple = $rippleData->ticker->price;
saveData($rippleName, $ripple);

$moneroURL = makeUrlForCryptoCurrencies($moneroName);
$moneroData = getData($moneroURL, false);
$monero = $moneroData->ticker->price;
saveData($moneroName, $monero);

$neoURL = makeUrlForCryptoCurrencies($neoName);
$neoData = getData($neoURL, false);
$neo = $neoData->ticker->price;
saveData($neoName, $neo);

$cardanoUrl = makeUrlForCryptoCurrencies($cardanoName);
$cardanoData = getData($cardanoUrl, false);
$cardano = $cardanoData->ticker->price;
saveData($cardanoName, $cardano);

$eosUrl = makeUrlForCryptoCurrencies($eosName);
$eosData = getData($eosUrl, false);
$eos = $eosData->ticker->price;
saveData($eosName, $eos);

$dashUrl = makeUrlForCryptoCurrencies($dashName);
$dashData = getData($dashUrl, false);
$dash = $dashData->ticker->price;
saveData($dashName, $dash);

function saveData($currency, $value)
{
        if(verifyCurrency($currency)){
                updateExchangeRates($currency, $value);
        }else {
                saveExchangeRates($currency, $value);
        }
}

function getData($url, $asArray){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, $asArray);
}

function makeUrlForCryptoCurrencies($coin){
        $loweredCoin = strtolower($coin); 
        return "https://api.cryptonator.com/api/ticker/eur-$loweredCoin";
}

function saveExchangeRates($currency, $value)
    {
        global $con;
        global $date;

        $mostValuable = ($value < 1.65 ? 1 : 0);

        $command = "INSERT INTO exchange_rates (currency, value, date, most_valuable) 
        VALUES ('$currency', '$value', '$date', $mostValuable);";
        $query 	= mysqli_query($con, $command);       

        if($query)
        { 
            return true;
        }
        return false;
    }

    function updateExchangeRates($currency,$value)
    {
        global $con;               
        global $date;

        $mostValuable = ($value < 1.65 ? 1 : 0);

        $sql = "UPDATE exchange_rates SET value='$value', date='$date', most_valuable=$mostValuable WHERE currency='$currency'";   
       
        $query 	= mysqli_query($con, $sql);

        if($query)
        { 
            return true;
        }

        return false;  
    }

    function verifyCurrency($currency)
    {
        global $con;
        $sql = "SELECT id FROM exchange_rates WHERE currency='$currency'";
        
        $query 	= mysqli_query($con, $sql);

        if(mysqli_num_rows($query)===1)
        {
            return true;
        }
        return false;
    }

