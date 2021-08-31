<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoTransactionList</title>
    </head>
    <body>
		<?php
		include 'PaynetClass.php';
		
		try{
			
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			//Servisin parametrelerini ayarla
			$params = new TransactionListParameters();
			$params->datab = "2020-03-04";
			$params->datai = "2020-04-05";
			
			//Servisi çalıştır
			$sonuc = $paynet->ListTransaction($params);
			
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