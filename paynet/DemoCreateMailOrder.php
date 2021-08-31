<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>DemoCreateMailOrder</title>
    </head>
    <body>
		<?php
		include 'PaynetClass.php';
		
		try{
			
			//Paynet secret keyi nesneye aktar
			$paynet = new PaynetClient("Buraya secret key değeri girilecektir");
			
			//Servisin parametrelerini ayarla
			$params = new MailOrderParameters();
			$params->amount = 120;
			$params->expire_date = 12;
			$params->name_surname = "Ödeme yapacak kişinin adı soyadı";
			$params->email = "Ödeme yapacak kişinin maili";
			$params->phone = "Ödeme yapacak kişinin gsm numarası";
			$params->send_mail = true;
			$params->send_sms = true;
			
			//Servisi çalıştır
			$sonuc = $paynet->CreateMailOrder($params);
			
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