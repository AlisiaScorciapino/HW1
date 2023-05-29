<?php

	require_once 'auth.php';
	// Se la sessione è scaduta, esco
	if (!checkAuth()) exit;

	// Imposto l'header della risposta
	header('Content-Type: application/json');

	news();

	function news(){

		$curl = curl_init();//inizializzazione

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://f1-latest-news.p.rapidapi.com/news/f1",
			CURLOPT_RETURNTRANSFER => true,//restituisce il risultato come stringa
			CURLOPT_ENCODING => "",//permette la decodifica della risposta,in questo caso è già settato perchè vuota
			CURLOPT_MAXREDIRS => 10,//dubbio
			CURLOPT_TIMEOUT => 30,//dubbio
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,//dubbio
			CURLOPT_CUSTOMREQUEST => "GET",//dubbio
			CURLOPT_HTTPHEADER => [
				"X-RapidAPI-Host: f1-latest-news.p.rapidapi.com",
				"X-RapidAPI-Key: bc800cc18fmsh4db17d475165be8p109bfcjsna2a2dd16502a"
			],
		]);

		$response = curl_exec($curl);//risultato dubbio
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}

?>