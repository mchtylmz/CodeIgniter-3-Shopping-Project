<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>Payment</title>
    </head>
    <body>

	<?php
	include 'PaynetClass.php';
		
	try{
		//Paynet secret keyi nesneye aktar
		$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			
		//Payment işlemi için parametreleri ayarla
		//Bu servise göndereceğiniz tutarı arayüzden almayıp, session veya veritabanı gibi güvenilir sunucu taraflı bir kaynaktan almanız ödemenin güvenliği açısından önemlidir.
		$paymentParams = new PaymentParameters();
		$paymentParams->amount = PaynetTools::FormatWithDecimalSeperator($_SESSION["amount"]);
		$paymentParams->reference_no = $_SESSION["reference-no"];
		$paymentParams->card_holder = $_REQUEST["card-holder"];
		$paymentParams->pan = $_REQUEST["card-number"];
		$paymentParams->month = $_REQUEST["expire-month"];
		$paymentParams->year = $_REQUEST["expire-year"];
		$paymentParams->cvc = $_REQUEST["cvc"];
		$paymentParams->instalment = $_REQUEST["instalment"];

		
		//Payment işlemini çalıştırır
		$result = $paynet->Payment($paymentParams);
			
		if($result->is_succeed)
			echo("<div style='color:green'>Başarılı</div>");
		else
			echo("<div style='color:red'>Başarısız</div>");
			
		var_dump($result);
			
	}
	catch (PaynetException $e)
	{
		echo $e->getMessage();
	}
	?>
	</body>
</html>
