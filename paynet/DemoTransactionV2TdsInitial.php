<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>Tds Initial</title>
    </head>
    <body>

	<?php
	include 'PaynetClass.php';
		
	try{
		//Paynet secret keyi nesneye aktar
		$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			
		//Tds initial işlemi için parametreleri ayarla
		//Bu servise göndereceğiniz tutarı arayüzden almayıp, session veya veritabanı gibi güvenilir sunucu taraflı bir kaynaktan almanız ödemenin güvenliği açısından önemlidir.
		$tdsInitialParams = new TdsInitialParameters();
		$tdsInitialParams->amount = PaynetTools::FormatWithDecimalSeperator($_SESSION["amount"]);
		$tdsInitialParams->reference_no = $_SESSION["reference-no"];
		$tdsInitialParams->card_holder = $_REQUEST["card-holder"];
		$tdsInitialParams->pan = $_REQUEST["card-number"];
		$tdsInitialParams->month = $_REQUEST["expire-month"];
		$tdsInitialParams->year = $_REQUEST["expire-year"];
		$tdsInitialParams->cvc = $_REQUEST["cvc"];
		$tdsInitialParams->instalment = $_REQUEST["instalment"];
		$tdsInitialParams->return_url = "Paynet'in işlem sonucunda dönüş yapacağı adresiniz"; //Ör:http://localhost/DemoTransactionV2TdsCookieBridge.php
			

		//Tds initial işlemini çalıştırır
		$result = $paynet->TdsInitial($tdsInitialParams);
			
		if($result->code == ResultCode::successful)
		{
			header('Location: '.$result->post_url); exit();
		}
		else
		{
			echo("<div style='color:red'>".$result->message."</div>");
		}	
	}
	catch (PaynetException $e)
	{
		echo $e->getMessage();
	}
	?>

	</body>
</html>
