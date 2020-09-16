<?php

namespace Hcode\PagSeguro;

use DOMDocument;
use DOMElement;
use Exception;

class Sender {

	private $hash;
	private $name;
	private $email;
	private $phone;
	private $document;

	public function __construct(
		string $hash,
		string $name,
		string $email,
		Phone $phone,
		Document $document)
	{
		
		if (!$hash) {

			throw new Exception("Informe a identificação do comprador.");

		}

		if (!$name) {

			throw new Exception("Informe o nome do comprador.");

		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			throw new Exception("O e-mail informado não é válido.");

		}

		$this->hash = $hash;
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
		$this->document = $document;

	}

	public function getDOMElement():DOMElement
	{
		$dom = new DOMDocument();

		$sender = $dom->createElement("sender");
		$sender = $dom->appendChild($sender);
		
		$hash = $dom->createElement("hash", $this->hash);
		$hash = $sender->appendChild($hash);
		
		$name = $dom->createElement("name", $this->name);
		$name = $sender->appendChild($name);
		
		$email = $dom->createElement("email", $this->email);
		$email = $sender->appendChild($email);
		
		$phone = $this->phone->getDOMElement();
		$phone = $dom->importNode($phone, true);
		$phone = $sender->appendChild($phone);
		
		$documents = $dom->createElement("documents");
		$documents = $sender->appendChild($documents);

		$document = $this->document->getDOMElement();
		$document = $dom->importNode($document, true);
		$document = $documents->appendChild($document);

		return $sender;
	}

}