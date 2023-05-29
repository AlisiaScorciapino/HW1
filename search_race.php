<?php

    // Se la sessione è scaduta, esco
    require_once 'auth.php';
    if (!checkAuth()) exit;

    // Imposto l'header della risposta
    header('Content-Type: application/json');

    race();
    function race(){

        $query = urlencode($_GET["race_no"]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://f1-race-schedule.p.rapidapi.com/api/race/".$query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: f1-race-schedule.p.rapidapi.com",
                "X-RapidAPI-Key: bc800cc18fmsh4db17d475165be8p109bfcjsna2a2dd16502a"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
?>

