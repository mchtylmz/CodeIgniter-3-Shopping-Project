<?php
//DemoTransactionV2TdsCharge.php sayfanızda cookie veya cookie bazlı session kullanmıyorsanız,
//Bu sayfayı kullanmanıza gerek olmayacaktır, tds_initial servisini çağrırken return_url parametresine DemoTransactionV2TdsCharge.php olarak kullanacağınız sayfanın adresini yazabilirsiniz.

//DemoTransactionV2TdsCharge.php sayfanızda cookie veya cookie bazlı session kullanıyorsanız
//tds_initial servisini çağırırken return_url parametresi ile bu sayfayı adres vererek, 
//ve bu sayfadaki formun action attribute'undan DemoTransactionV2TdsCharge.php olarak kullanacağınız sayfanın adresini ayarlayıp,
//sitesinizde cookie'ler ile ilgili hiç bir ayar değişikliği yapmadan ödeme gerçekleştirebilirsiniz.

//DemoTransactionV2TdsCharge.php sayfanızda cookie veya cookie bazlı session kullanıyorsanız
//Ve ödeme akışınıza bu sayfayı eklemek istemiyorsanız,
//DemoTransactionV2TdsCharge.php sayfasında ihtiyaç duyacağınız tüm cookie'leri "samesite=none; Secure;" olarak işaretlemelisiniz.
//PHP'nin versiyonları, barındırıldıkları ortamlar, web sitesinin ayarları çok farklı olabildiği için, her konfigürasyon için geçerli bir örnek vermemiz mümkün olmamaktadır.
//Bu seçeneği kullanmak istiyorsanız, https://www.chromium.org/updates/same-site ve https://www.chromium.org/updates/same-site/incompatible-clients sayfalarındaki açıklamaları okumanızı öneririz.

?>
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
    	<title>Cookie Bridge</title>
		<style>
			body{
				text-align:center;
				font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			}
		</style>
    </head>
    <body>
		<div>Ödeme sonucu sayfasına yönlendiriliyorsunuz...</div>

		<form action="DemoTransactionV2TdsCharge.php" method="POST">
			<input type="hidden" name="session_id" value="<?php if(isset($_REQUEST["session_id"])){ echo $_REQUEST["session_id"];}  ?>">
			<input type="hidden" name="token_id" value="<?php if(isset($_REQUEST["token_id"])){ echo $_REQUEST["token_id"];} ?>">
			<input type="hidden" name="reference_no" value="<?php if(isset($_REQUEST["reference_no"])){ echo $_REQUEST["reference_no"];} ?>">
		</form>
		<script>
			document.getElementsByTagName("form")[0].submit();
		</script>
	</body>
</html>
