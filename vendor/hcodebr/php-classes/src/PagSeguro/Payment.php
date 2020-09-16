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

		$payment = $dom->createElement("payment");
		$payment = $dom->appendChild($payment);

		$mode = $dom->createElement("mode", $this->mode);
		$mode = $payment->appendChild($mode);
		
		$currency = $dom->createElement("currency", $this->currency);
		$currency = $payment->appendChild($currency);
		
		$notificationURL = $dom->createElement("notificationURL", 
		Config::NOTIFICATION_URL);
		$notificationURL = $payment->appendChild($notificationURL);
		
		$receiverEmail = $dom->createElement("receiverEmail", 
		(Config::SANDBOX) ? Config::SANDBOX_EMAIL : Config::PRODUCTION_EMAIL);
		$receiverEmail = $payment->appendChild($receiverEmail);
		
		$sender = $this->sender->getDOMElement();
		$sender = $dom->importNode($sender, true);
		$sender = $payment->appendChild($sender);
		
		$items = $dom->createElement("items");
		$items = $payment->appendChild($items);
		
		foreach($this->items as $_item) {
			
			$item = $_item->getDOMElement();
			$item = $dom->importNode($item, true);
			$item = $items->appendChild($item);
			
		}
		
		$reference = $dom->createElement("reference", $this->reference);
		$reference = $payment->appendChild($reference);
		
		$shipping = $this->shipping->getDOMElement();
		$shipping = $dom->importNode($shipping, true);
		$shipping = $payment->appendChild($shipping);
		
		$extraAmount = $dom->createElement("extraAmount", $this->extraAmount);
		$extraAmount = $payment->appendChild($extraAmount);
		
		$method = $dom->createElement("method", $this->method);
		$method = $payment->appendChild($method);
		
		switch ($this->method) {

			case Method::CREDIT_CARD:
				
				$creditCard = $this->creditCard->getDOMElement();
				$creditCard = $dom->importNode($creditCard, true);
				$creditCard = $payment->appendChild($creditCard);

			break;

			case Method::DEBIT:
				
				$bank = $this->bank->getDOMElement();
				$bank = $dom->importNode($bank, true);
				$bank = $payment->appendChild($bank);

			break;
		}
		

		return $dom;

	}
	
}