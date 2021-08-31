<?php 

session_start();

include 'PaynetClass.php';

//Aşağıdaki scripte data-amount parametresi ile aktarılan tutar, taksit bilgilerin görüntülenmesi için eklenmektedir.

//Bu aynı tutarın bir sonraki adım olan sunucu taraflı ödeme onaylama servisinde (v1/transaction/charge) de gönderilmesi gerekmektedir.

//Scripte ve ödeme onaylama servisine iletilen tutarların farklı olması durumunda güvenlik sebebiyle ödeme onaylama servisi hata dönecektir.

//Ödeme onaylama servisine iletilen tutarın, form ile  alınmaması, veri tabanı veya oturum (SESSION) gibi güvenli bir kaynaktan alınması gerekmektedir.

//Olması gereken bu akışı temsil etmek için aşağıda tutar bilgisi oturuma kaydedilmiştir ve DemoChargeServer.php dosyasındaki ödeme onaylama kısmında da oturuma kayıtlı bu tutar kullanılacaktır.

$_SESSION['amount']=123.45;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>DemoCharge</title>
	</head>
	
	<body>
	     <form action="DemoChargeServer.php" method="post" name="checkout-form" id="checkout-form">
	            <script type="text/javascript"
	                    class="paynet-button"
	                    src="https://pts-pj.paynet.com.tr/public/js/paynet.js"
	                    data-key="Buraya publishable key değeri girilecektir"
						data-amount="<?php echo PaynetTools::FormatWithoutDecimalSeperator($_SESSION["amount"])?>"
	                    data-image="http://icons.iconarchive.com/icons/stalker018/mmii-flat-vol-3/72/dictionary-icon.png"
	                    data-button_label="Ödemeyi Tamamla"
	                    data-description="Ödemenizi tamamlamak için bilgileri girip tamam butonuna basınız"
	                    data-agent=""
	                    data-add_commission_amount="false"
	                    data-no_instalment="false"
	                    data-tds_required="false"
	                    data-pos_type="5">
	            </script>
				
				<!--aşağıdaki değerler ödeme tamamlandıktan sonra DemoChargeServer.php sayfasına post edilecek-->
	            <input type="hidden" id="musteri_referans" name="musteri_referans" value="1234">
	            <input type="hidden" id="musteri_referans2" name="musteri_referans2" value="1111">

	      </form>
	</body>
</html>