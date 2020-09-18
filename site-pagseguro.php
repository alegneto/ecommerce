<?php 

use Hcode\Model\Order;
use Hcode\Model\User;
use Hcode\Page;
use Hcode\PagSeguro\Address;
use Hcode\PagSeguro\Config;
use Hcode\PagSeguro\CreditCard;
use Hcode\PagSeguro\CreditCard\Holder;
use Hcode\PagSeguro\CreditCard\Installment;
use Hcode\PagSeguro\Document;
use Hcode\PagSeguro\Item;
use Hcode\PagSeguro\Payment;
use Hcode\PagSeguro\Phone;
use Hcode\PagSeguro\Sender;
use Hcode\PagSeguro\Shipping;
use Hcode\PagSeguro\Transporter;

$app->post('/payment/credit', function() {

	User::verifyLogin(false);

	$order = new Order();
	$order->getFromSession();
	$order->get((int)$order->getidorder());

	$birthDate = new DateTime($_POST['birth']);

	$address = $order->getAddress();

	$cart = $order->getCart();

	$cpf = new Document(Document::CPF, $_POST['cpf']);

	$phone = new Phone($_POST['ddd'], $_POST['phone']);

	$shippingAddress = new Address(
		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry(),
		$address->getdeszipcode()
	);

	$sender = new Sender(
		$_POST['hash'],
		$order->getdesperson(),
		$order->getdesemail(),
		$phone,
		$cpf
	);
	
	$holder = new Holder(
		$order->getdesperson(),
		$cpf,
		$birthDate,
		$phone
	);

	$shipping = new Shipping(
		$shippingAddress,
		Shipping::PAC,
		(float)$cart->getvlfreight()
	);

	$installment = new Installment(
		(int)$_POST['installments_qtd'], 
		(float)$_POST['installments_value']
	);

	$billingAddress = new Address(
		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry(),
		$address->getdeszipcode()
	);

	$creditCard = new CreditCard(
		$_POST['token'],
		$installment,
		$holder,
		$billingAddress
	);

	$payment = new Payment(
		$order->getidorder(),
		$sender,
		$shipping
	);

	foreach ($cart->getProducts() as $product) {

		$item = new Item(
			(int)$product['idproduct'], 
			$product['desproduct'],
			(int)$product['nrqtd'],
			(float)$product['vlprice']
		);

		$payment->addItem($item);

	}

	$payment->setCreditCard($creditCard);

	Transporter::sendTransaction($payment);
	
	echo json_encode([
		"success" => true
	]);

});

$app->get('/payment', function() {

	User::verifyLogin(false);

	$order = new Order();
	$order->getFromSession();
	
	$years = [];
	for ($y = date('Y'); $y < date('Y')+14; $y++) {
		array_push($years, $y);
	}

	$page = new Page();
	$page->setTpl("payment", [
		"order" => $order->getValues(),
		"msgError" => Order::getError(),
		"years" => $years,
		"pagseguro" => [
			"urlJS" => Config::getUrlJS(),
			"id" => Transporter::createSession(),
			"maxInstallmentNoInterest" => Config::MAX_INSTALLMENT_NO_INTEREST,
			"maxInstallment" => Config::MAX_INSTALLMENT
		]
	]);
});