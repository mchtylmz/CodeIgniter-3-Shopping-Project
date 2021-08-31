<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoGetRatios</title>
    </head>
    <body>
		<?php
		//Tüm datayı görebilmek için 
		ini_set('xdebug.var_display_max_depth', -1);
		ini_set('xdebug.var_display_max_children', -1);
		ini_set('xdebug.var_display_max_data', -1);
		
		include 'PaynetClass.php';
		
		try{
			
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			//Servisin parametrelerini ayarla
			$params = new RatioParameters();
			
			//Servisi çalıştır
			$sonuc = $paynet->GetRatios($params);
			
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