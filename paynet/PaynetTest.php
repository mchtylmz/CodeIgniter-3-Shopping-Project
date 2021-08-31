<?php
 include 'PaynetClass.php'; 

 $isLive = '';
 $agentId = '';
 $publishableKey = '';
 $secretKey = '';
 $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

 if($isPost)
 {
	$isLive = $_POST['isLive'];
	$agentId = $_POST['agentId'];
	$publishableKey = $_POST['publishableKey'];
	$secretKey = $_POST['secretKey']; 
 }

 ?>
<html lang="tr">
<head>
 	<title>Paynet Test</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
		.header {
			padding:20px; 
			background:#007bff; 
			color:#FFF; 
			text-align:center; 
			font-size:22px;
			margin-bottom:20px;

		}

		.paynet-ratio-table
		{
			width:100%;
		}
	</style>
</head>
<body><div class="header">
		Paynet API Test
	</div>

	<form name="form" action="<?php $_PHP_SELF ?>" method="POST">	
		<div class="container">

			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Publishable Key</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="publishableKey" placeholder="Publishable Key" value="<?PHP echo($publishableKey); ?>" required>
				</div>
			</div>
		
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Secret Key</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="secretKey" placeholder="Secret Key" value="<?PHP echo($secretKey); ?>" required>
				</div>
			</div>
		
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Bayi Kodu</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="agentId" placeholder="Bayi Kodu" value="<?PHP echo($agentId); ?>" required>
				</div>
			</div>

			<br></br>
			
			<div class="form-check">
				<input class="form-check-input" type="radio" name="isLive" id="gridRadios1" value="true" <?PHP if($isLive == 'true'){ ?> checked <?PHP }?> required>
					<label class="form-check-label" for="gridRadios1">Canlı Sistem</label>	
			</div>
			<br>
			
			<div class="form-check">
				<input class="form-check-input" type="radio" name="isLive" id="gridRadios2" value="false" <?PHP if($isLive == 'false'){ ?> checked <?PHP }?>  required>
				<label class="form-check-label" for="gridRadios2">
				Test Sistem
				</label>
			</div>	
			
			<div class="form-group row">
				<div class="col-sm-12">
					<br><br><button class="btn btn-primary" type="submit">Teste Başla</button>
				</div>
			</div>
	</form>

	<?php

		if($isPost)
		{
			echo "<h3>Kontrol Sonucu:</h3>";
			
			try
			{

				$parameters = new CheckIntegrationParameters();
				$parameters->agent_id = $agentId;
				$parameters->publishable_key = $publishableKey;
				$parameters->secret_key = $secretKey;
				
				//Paynet secret keyi nesneye aktar
				$paynet = new PaynetClient($secretKey, filter_var($isLive, FILTER_VALIDATE_BOOLEAN));
				
				//Bağlantı kontrolü yap
				$checkResult = $paynet->CheckConnectionAndIntegrationInfo($parameters);

				if($checkResult->code != ResultCode::successful)
				{
					echo "<h3><div class='alert alert-danger col-md-12'>".$checkResult->message."</div></h3>";	
				}
				else
				{										
					//Bağlantı var ise örnek olarak oran servisinden oranları oku
					$params = new RatioParameters();
					$ratioResult = $paynet->GetRatios($params);
					if($ratioResult->code != ResultCode::successful)
					{
						echo "<h3><div class='alert alert-danger'>Paynet servisinden kontrol amaçlı oranlar okunamadı, hata: ".$ratioResult->message."</div></h3>";
					}
					else
					{
						echo "<h3><div class='alert alert-success'>Tebrikler! Bağlantı ve entegrasyon bilgisi kontrolünüz başarılı, Paynet servisinden kontrol amaçlı taksit oranlarınız okundu.</div></h3>";
						echo "<hr/><h3>Taksit Oranları </h3>(Paynet hesabınızdan otomatik alınmıştır.) <hr/>";
						$installmentsHtml = PaynetTools::getInstallmentsHtml($ratioResult->data);
						echo $installmentsHtml;
					}
			
				}
			}
			catch (PaynetException $e)
			{
				echo $e->getMessage();
			}
		}	
	?>
	</body>
</html>