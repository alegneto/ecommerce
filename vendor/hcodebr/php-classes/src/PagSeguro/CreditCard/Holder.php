<?php

namespace Hcode\PagSeguro\CreditCard;

use DateTime;
use DOMDocument;
use DOMElement;
use Exception;
use Hcode\PagSeguro\Document;
use Hcode\PagSeguro\Phone;

class Holder
{

	private $name;
	private $document;
	private $birthDate;
	private $phone;

	public function __construct(
		string $name,
		Document $document,
		DateTime $birthDate,
		Phone $phone)
	{
		
		if (!$name) {

			throw new Exception("Informe o nome do comprador.");

		}

		$this->name = $name;
		$this->document = $document;
		$this->birthDate = $birthDate;
		$this->phone = $phone;

	}

	public function getDOMElement():DOMElement
	{
		$dom = new DOMDocument();

		$holder = $dom->createElement("holder");
		$holder = $dom->appendChild($holder);
		
		$name = $dom->createElement("name", $this->name);
		$name = $holder->appendChild($name);
		
		$documents = $dom->createElement("documents");
		$documents = $holder->appendChild($documents);
		
		$document = $this->document->getDOMElement();
		$document = $dom->importNode($document, true);
		$document = $documents->appendChild($document);
		
		$birthDate = $dom->createElement("birthDate", $this->birthDate->format("d/m/Y"));
		$birthDate = $holder->appendChild($birthDate);

		$phone = $this->phone->getDOMElement();
		$phone = $dom->importNode($phone, true);
		$phone = $holder->appendChild($phone);
		
		return $holder;
	}
}