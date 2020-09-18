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

	const SANDBOX_URL_TRANSACTION = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";
	const PRODUCTION_URL_TRANSACTION = "https://ws.pagseguro.uol.com.br/v2/transactions";

	const SANDBOX_URL_NOTIFICATION = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications";
	const PRODUCTION_URL_NOTIFICATION = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications";

	const MAX_INSTALLMENT_NO_INTEREST = 6;
	const MAX_INSTALLMENT = 10;

	const NOTIFICATION_URL = "http://www.ecommerce.com.br/payment/notification";

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

	public static function gerUrlTransaction(): string
	{
		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_TRANSACTION : Config::PRODUCTION_URL_TRANSACTION;
	}

	public static function getNotificationTransactionURL()
	{
		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_NOTIFICATION : Config::PRODUCTION_URL_NOTIFICATION;
	}
}