<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoReversedRequest</title>
    </head>
    <body>
		<?php
		include 'PaynetClass.php';
		
		try{
			
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			//Servisin parametrelerini ayarla
			$params = new ReversedRequestParameters();
			$params->xact_id = "işlem numarası";
		
			//Servisi çalıştır
			$sonuc = $paynet->ReversedRequest($params);
			
			//sonucu ekrana yazdır
			var_dump($sonuc);
			
		}
		catch (PaynetException $e)
		{
		    echo $e->getMessage();
		}
		?>
	</body>
</html>