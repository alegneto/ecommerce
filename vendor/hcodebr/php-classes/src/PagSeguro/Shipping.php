<?php

namespace Hcode\PagSeguro;

use DOMDocument;
use DOMElement;
use Exception;

class CreditCard {

	const PAC = 1;
	const SEDEX = 2;
	const OTHER = 3;

	private $address;
	private $type;
	private $cost;
	private $addressRequired;

	public function __construct(
		Address $address,
		int $type,
		float $cost,
		bool $addressRequired
	)
	{
		
		if ($type < 1 or $type > 3) {

			throw new Exception("Informe um tipo de frete válido.");

		}

		$this->address = $address;
		$this->type = $type;
		$this->coast = $cost;
		$this->addressRequired = $addressRequired;

	}

	public function getDOMElement():DOMElement
	{
		$dom = new DOMDocument();

		$shipping = $dom->createElement("shipping");
		$shipping = $dom->appendChild($shipping);
		
		$address = $this->address->getDOMElement();
		$address = $dom->importNode($address, true);
		$address = $shipping->appendChild($address);
		
		$type = $dom->createElement("type", $this->type);
		$type = $shipping->appendChild($type);
		
		$coast = $dom->createElement("coast", number_format($this->coast, 2, ".", ""));
		$coast = $shipping->appendChild($coast);
		
		$addressRequired = $dom->createElement("addressRequired", ($this->addressRequired) ? "true" : "false");
		$addressRequired = $shipping->appendChild($addressRequired);
				
		return $shipping;
	}
	
}