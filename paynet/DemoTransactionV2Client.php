<?php
session_start();

//Taksit bilgilerinin gösterilmesinde ve tds_initial kullanılacak tutar burada session'a setlenmiştir.
$_SESSION['amount']=123.45; //işlem tutarı
$_SESSION['reference-no'] = "12380450"; //her ödeme işleminiz için unique olmalı.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>TransactionV2</title>
	<link rel="stylesheet" href="./css/demo.css"/>
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/jquery.validate.additional-methods.min.js"></script>
	<script src="js/jquery.validate.messages_tr.js"></script>
</head>
<body>

	<form action="DemoTransactionV2TdsInitial.php" method="post" name="checkout-form" id="checkout-form">
		<table>
			<tr>
				<td>Tutar: </td>
				<td><?php echo $_SESSION["amount"]?> TL</td>
			</tr>
			<tr>
				<td>Referans No: </td>
				<td><?php echo $_SESSION["reference-no"]?></td>
			</tr>
			<tr>
				<td>Kart Üzerindeki İsim: </td>
				<td><input type="text" name="card-holder" /></td>
			</tr>
			<tr>
				<td>Kart Numarası: </td>
				<td><input type="text" name="card-number" id="card-number" /></td>
			</tr>
			<tr>
				<td>Son kullanma tarihi ( ay / yıl ): </td>
				<td>
					<table class="expire-date">
					    <tr>
							<td>
								<select name="expire-month">
									<option value="">...</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								 </select>
							</td>
							<td>	                 
								<select name="expire-year">
									<option value="">...</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									<option value="2027">2027</option>
									<option value="2028">2028</option>			
								 </select>   
							</td>
						</tr>
					</table>

	            </td>
			</tr>
			<tr>
				<td>CVC: </td>
				<td><input type="password" minlength="3" maxlength="4" name="cvc" /></td>
			</tr>
			<tr>
				<td>3D Ödeme: </td>
				<td><input type="checkbox" name="is-tds" id="is-tds" value="true" checked /></td>
			</tr>
			<tr>
				<td>Taksit:</td>
				<td>
	                <div id="instalments-div">
						Taksitleri görmek için kart numaranızı giriniz.
	                </div>
					<input type="hidden" name="instalment" id="instalment">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" id="checkout-button">Öde</button>
				</td>
			</tr>		
			
		</table>
	</form>

	<script>
	//form doğrulama
	$("#checkout-form").validate({
		ignore: [],
		lang:'tr',
		rules: {
			"amount": "required",
			"reference-no": "required",
			"card-holder": "required",
			"card-number": {
				required: true,
				creditcard: true
			},
			"expire-month": "required",
			"expire-year": "required",
			"cvc": "required",
			"instalment": "required"
		 },
		submitHandler: function(form) {
		   $("#checkout-button").attr("disabled", true).text("Ödeme başlatılıyor...");
		   form.submit();
		}
	});
	
	//3D Ödeme seçeneği butonuna tıklandığında, formun post edileceği adresi değiştirir
	$("#is-tds").click(function(){
		if($(this).is("checked"))
		{
			$("#checkout-form").attr("action", "DemoTransactionV2TdsInitial.php");
		}
		else
		{
			$("#checkout-form").attr("action", "DemoTransactionV2Payment.php");
		}
	})

	//Kart numarası değiştiğinde gerekiyorsa taksitleri yükler
	$("#card-number").bind("input",function() { 

		var cardNumber = cleanCardNumber($(this).val());
		var currentCardBin = $(this).data("current-card-bin");
		var newCardBin = cardNumber.substr(0, 6); //Kart bini kart numarasının ilk 6 karakteridir

		if(newCardBin != currentCardBin)
		{
			$(this).data("current-card-bin", newCardBin);
			loadInstalments();
		}

	});

	//Listeden taksit seçildiğinde hidden taksit seçeneğini ayarlar
	$("#instalments-div").on("click", "input", function(){
		var selectedInstalment = $(this).val();
		$("#instalment").val(selectedInstalment);
		$("#checkout-form").validate().element("#instalment");
	})


	function loadInstalments()
	{
		var $instalmentsDiv = $("#instalments-div");
		var cardNumber = cleanCardNumber($("#card-number").val());
		var cardBin = cardNumber.substr(0, 6);

		if(!isBinValid(cardBin))
		{
			$instalmentsDiv.html("Taksitleri görmek için kart numaranızı giriniz.");
			$("#instalment").val("");
			return;
		}

		$instalmentsDiv.html("Taksit seçenekleri yükleniyor...");

		$.get("DemoTransactionV2Instalments.php", {cardBin:cardBin})
			.done(function(data) {
				$instalmentsDiv.html(data);
			})
			.fail(function() {
				$instalmentsDiv.html("Taksitler yüklenirken hata oluştu.");
			})
	}

	function cleanCardNumber(val) {
        if (val) {
            return val.replace(/\ /g, '').replace(/-/g, '');
        }
        return val;
    }

	function isBinValid(cardBin)
	{
		var isOnlyDigit = /^\d+$/.test(cardBin);
		return cardBin.length == 6 && isOnlyDigit;
	}
	</script>


</body>
</html>
