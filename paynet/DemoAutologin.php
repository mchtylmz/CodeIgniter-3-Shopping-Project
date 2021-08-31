<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoAutologin</title>
    </head>
    <body>
		<?php
		include 'PaynetClass.php';
		
		try{
		
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			//Servisin parametrelerini ayarla
			$params = new AutologinParameters();
			$params->agent_id = "bayikodu";
			$params->user_name = "kullanıcıadı";
			
		
			//Servisi çalıştır
			$sonuc = $paynet->AutoLogin($params);
			
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