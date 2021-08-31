<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>Tds Charge</title>
    </head>
    <body>

	<?php
	include 'PaynetClass.php';
		
	try{
		//Paynet secret keyi nesneye aktar
		$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			
		//Tds charge işlemi için parametreleri ayarla
		$tdsChargeParams = new TdsChargeParameters();
		$tdsChargeParams->session_id = $_REQUEST["session_id"];
		$tdsChargeParams->token_id = $_REQUEST["token_id"];
				
		
		//Tds charge işlemini çalıştırır
		$result = $paynet->TdsCharge($tdsChargeParams);
			
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
