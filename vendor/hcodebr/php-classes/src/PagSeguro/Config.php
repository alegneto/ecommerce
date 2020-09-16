<?php

namespace Hcode\PagSeguro;

class Config {

	const SANDBOX = true;

	const SANDBOX_EMAIL = "alegneto@hotmail.com";
	const PRODUCTION_EMAIL = "alegneto@hotmail.com";

	const SANDBOX_SESSIONS = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions";
	const PRODUCTION_SESSIONS = "https://ws.pagseguro.uol.com.br/v2/sessions";

	const SANDBOX_URL_JS = "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
	const PRODUCTION_URL_JS = "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";

	const MAX_INSTALLMENT_NO_INTEREST = 6;
	const MAX_INSTALLMENT = 10;

	const NOTIFICATION_URL = "http://www.html5dev.com.br/payment/notification";

	public static function getAuthentication(): array
	{
		if (Config::SANDBOX === true) {
			return [
				"email" => Config::SANDBOX_EMAIL,
				"token" => getenv("SANDBOX_TOKEN")
			];
		}  else {
			return [
				"email" => Config::PRODUCTION_EMAIL,
				"token" => getenv("PRODUCTION_TOKEN")
			];
		}
	}

	public static function gerUrlSessions(): string
	{
		return (Config::SANDBOX === true) ? Config::SANDBOX_SESSIONS : Config::PRODUCTION_SESSIONS;
	}

	public static function getUrlJS()
	{
		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_JS : Config::PRODUCTION_URL_JS;
	}
}