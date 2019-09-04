<?php

    /*
        This script will run once to fetch the translated names for Portuguese language from this 
        website https://www.xe.com/pt/currencytables/?from=EUR&date=2019-08-15
        The script will parse the html and fetch the relevant data after that it will update the database 
        with the fetched data.

        It will then fetch the English names and country flags from the 
        site https://restcountries.eu/rest/v2/alpha/$countryCode and update the database accordingly

        When fetching the country flags this script will convert them from svg to png with a 
        small resolution and then it will base64 encode them and update the database accordingly
     */


    include('simple_html_dom.php');
    require_once __DIR__.'/php-svg/autoloader.php';

    use SVG\SVG;

    $con = mysqli_connect("YOUR_DB_SERVER_URL","YOUR_DB_USERNAME","YOUR_DB_PASSWORD","YOUR_SCHEMA");
    if (!$con) {
        echo "Connection error: " . mysqli_connect_errno() . " - " . mysqli_connect_error();
        exit();
    }

    mysqli_set_charset($con, "utf8");

    class Rate {

        public $code;
        public $img;
    }

    $portugueseCurrencyNames = getPortugueseCurrencyNames();
    $currenciesFlags = [];

    foreach($portugueseCurrencyNames as $key => $value){
        $image = getImageForCurrency($key);
        $currenciesFlags[$key] = $image;
    }
    
    $currencies = array_keys($portugueseCurrencyNames);

    foreach($currencies as $c){
        $rate = new Rate();
        $rate->code = $c;
        $rate->img = $currenciesFlags[$c];

        if(verifyCurrency($c)){
            updateCurrency($rate);
        }
    }

    function getPortugueseCurrencyNames(){
        $html = file_get_html('https://www.xe.com/pt/currencytables/?from=EUR&date=2019-08-15');

        $arrayOfCodes = [];
        $arrayOfNames = [];

        foreach($html->find('a') as $e) 
        {
            array_push($arrayOfCodes, $e->innertext);
        }

        foreach($html->find('td') as $e) 
        {
            array_push($arrayOfNames, $e->innertext);
        }

        $codes = array_values($arrayOfCodes);
        $names = array_values($arrayOfNames);


        $currencyCodes = [];
        $currencyNAmes = [];

        for($i = 0; $i < count($codes); $i++){
            if(strpos($codes[$i], ',') > -1 || strpos($codes[$i], '/') > -1 || strpos($codes[$i], 'Topo') > -1 || strpos($codes[$i], 'XE') > -1 || strpos($codes[$i], 'mercado') > -1){
                continue;
            }else {
                array_push($currencyCodes, $codes[$i]);
            }
        }

        for($i = 0; $i < count($names)-22; $i++){
            if(strpos($names[$i], ',') > -1 || strpos($names[$i], '/') > -1 || strpos($names[$i], '▼') > -1){
                continue;
            }else {
                array_push($currencyNAmes, $names[$i]);
            }
        }

        $parsedValues = [];

        for($i = 0; $i < count($currencyNAmes); $i++){
            $parsedValues[$currencyCodes[$i]] = $currencyNAmes[$i];
        }
        return $parsedValues;
    }


    function getImageForCurrency($code){
        $countryCode = strtolower(substr($code, 0, -1));
        $filename = strtolower($code);
        $url = "https://restcountries.eu/rest/v2/alpha/$countryCode";
        $data = getData($url, true); 
        $imageUrl = $data["flag"];
        if(!empty($imageUrl)){
            $image = SVG::fromFile($imageUrl);
            $doc = $image->getDocument();
            $rasterImage = $image->toRasterImage(120, 60);
            imagepng($rasterImage, "$filename.png");
            $base64Image = base64_encode(file_get_contents("$filename.png"));
            unlink("$filename.png");
            return $base64Image;
        }
        return "";    
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

    function updateCurrency($rate)
    {
        global $con;     

        $sql = "UPDATE exchange_rates SET img='$rate->img' WHERE currency='$rate->code'";
       
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
?>