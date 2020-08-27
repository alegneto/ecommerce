<?php

namespace Hcode\PagSeguro;

use \GuzzleHttp\Client;

class Transporter {

	public static function createSession()
	{

		$client = new Client();
		$response = $client->request('POST', Config::gerUrlSessions() . "?" . 
			http_build_query(Config::getAuthentication()));
		
		$xml = simplexml_load_string($response->getBody()->getContents());

		return (string)$xml->id;
	}
}