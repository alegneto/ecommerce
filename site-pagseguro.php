<?php 

use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\PagSeguro\Config;
use \GuzzleHttp\Client;

$app->get('/payment/pagseguro', function() {

	$client = new \GuzzleHttp\Client();
	$response = $client->request('POST', Config::gerUrlSessions() . "?" . http_build_query(Config::getAuthentication()));

	echo $response->getStatusCode(); // 200
	echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
	echo $response->getBody()->getContents(); // '{"id": 1420053, "name": "guzzle", ...}'

});
