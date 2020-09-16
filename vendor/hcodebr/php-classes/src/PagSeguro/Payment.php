<?php

namespace Hcode\PagSeguro;

use DOMDocument;
use Hcode\PagSeguro\Payment\Method;

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
	private $bank;

	public function __construct(
		string $reference,
		Sender $sender,
		Shipping $shipping,
		float $extraAmount = 0.00
	)
	{
		
		$this->sender = $sender;
		$this->shipping = $shipping;
		$this->reference = $reference;
		$this->extraAmount = number_format($extraAmount, 2, ".", "");

	}
	
	public function addItem(Item $item)
	{
		array_push($this->items, $item);
	}
	
	public function setCreditCard(CreditCard $creditCard)
	{
		
		$this->creditCard = $creditCard;
		$this->method = Method::CREDIT_CARD;

	}
	
	public function setBank(Bank $bank)
	{

		$this->bank = $bank;
		$this->method = Method::DEBIT;

	}
	
	public function setBoleto()
	{

		$this->method = Method::BOLETO;

	}
	
	public function getDOMDocument():DOMDocument
	{

		$dom = new DOMDocument("1.0", "ISO-8859-1");


		return $dom;

	}
	
}