<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoCharge Sunucu sayfası</title>
    </head>
    <body>
		<?php
		include 'PaynetClass.php';
		
		try{
		
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			
			//Charge işlemi için parametreleri ayarla
			$chargeParams = new ChargeParameters();
			$chargeParams->session_id = $_REQUEST["session_id"];
			$chargeParams->token_id = $_REQUEST["token_id"];
			$chargeParams->amount = PaynetTools::FormatWithoutDecimalSeperator($_SESSION["amount"]);
				
		
			//Charge işlemini çalıştırır
			$result = $paynet->ChargePost($chargeParams);
			
			if($result->is_succeed == true)
				echo("<div style='color:green'>Başarılı</div>");
			else
				echo("<div style='color:red'>Başarısız</div>");
			
			var_dump($result);
			
		}
		catch (PaynetException $e)
		{
			echo $e->getMessage();
		}
		session_destroy();
		?>
	</body>
</html>
