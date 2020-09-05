<?php

namespace Hcode\PagSeguro;

class Payment {

	private $mode = "default";
	private $method;
	private $sender;
	private $currency = "BRL";
	private $notificationURL;
	private $items = [];
	private $extraAmount = 0.00;
	private $reference = "";
	private $shipping;
	private $creditCard;

}