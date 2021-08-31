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
    <title>DemoChargeCustom</title>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript"
            class="paynet-button"
            src="https://pts-pj.paynet.com.tr/public/js/paynet-custom.js"
            data-form="#checkout-form"
            data-key="Buraya publishable key değeri girilecektir"
            data-amount="<?php echo PaynetTools::FormatWithDecimalSeperator($_SESSION["amount"])?>"
            data-description="Ödemenizi tamamlamak için bilgileri girip tamam butonuna basınız"
            data-agent=""
            data-add_commission_amount="false"
            data-no_instalment="false"
            data-tds_required="false"
            data-pos_type="5">
    </script>

    <script type="text/javascript">

    	

	        //Hataları Listeleyen method.
	        function showError(code, message) {
	            var $errorBox = $('<p></p>');
	            $errorBox.text('Code:' + code + ' Message:' + message);
	            $('.alert').append($errorBox);
	            $('.alert').show();
	        }
	
	        //Sayfadaki tüm hataları temizleyen method
	        function clearError() {
	            $('.alert').html('').hide();
	        }


	    	
	        $(function () 
	    	{
		    

	            //Sayfada validation hatası olduğunda validationları yakalamamıza yardımcı olur.
	            Paynet.events.validationError(function (e) {
	                showError(e.code, e.message);
	            });
	            
	
	            //Öde butonuna tıklandığında çalışır, ve sayfadaki hata mesajlarını temizler. Öde butonunu tıklandığında farklı işlemler daha yapmak isterseniz by methodu kullanabilirsiniz.
	            Paynet.events.onPaymentClick(function () {
	                clearError();
	            });
	
	            //Yetkilendirmeyi kontrol eden method.
	            Paynet.events.onAuthentication(function (c) {
	                if (!c.ok) {
	                    showError(c.code, c.message);
	                }
	            });
	
	            //Paynet javascript kütüphanesinin 
	            Paynet.events.onLoad(function () {
	                console.log('paynet library loaded');
	            });
	
	            //3D'li işlemlerde yönlendirme işlemini yapan method.
	            Paynet.events.onTdsRedirect(function () {
	                console.log('3D doğrulama için yönlendiriliyorsunuz');
	            });
	
	            //Token oluşturmasını sağlayan method.
	            Paynet.events.onCreateToken(function (c) {
	                if (!c.ok) {
	                    showError(c.code, c.message);
	                }
	            });
	
	            //Kredi kartı numarası girildiğinde çalışır ve bin nuamrasına göre kredi kartını tanır, taksit seçeneklerini hesaplayıp taksit tablosunu oluşturur.
	            Paynet.events.onCheckBin(function (d) {
	                    if (d && d.ok) 
	                    {
	    					$table = $('.installment-table');
	                        $table.html('');
	
	                        //logoyu ekle
	                        $table.append('<img src="'+d.bank.logoUrl+'">');
	
	
	                        //taksitleri sırala
	                        d.bank.installments.sort(function (current, next) {
	                            if (current.instalment > next.instalment) return 1;
	                            if (current.instalment < next.instalment) return -1;
	
	                            return 0;
	                        });
	
	
							//bu örnekte taksit seçenekleri bir tabloya satır olarak eklenecek
							var installments = d.bank.installments;
							
	                        $table.append("<table>");
	                        for (i = 0; i < installments.length; i++) 
	                       	{
	                            $table.append("<tr><td><input type='radio' name='__installment' data-key='"+installments[i].instalment_key+"'></td><td> "+installments[i].desc+"</td><td>"+installments[i].instalment_amount+"</td></tr>");
	                        }
	                        $table.append("</table>");

							//taksit seçeneklerini göster
	                        $('.installment-table').show();

	                    	
							//3d ödeme gerekli ise işaretle, değişime kapat ve gizle
	                        if (d.tdsState == 'required') {
	                            $('#tds').attr('checked', 'checked');
	                            $('#tds').attr('disabled', 'disabled');
	                            $('#isTds').hide();
	                        }
	                        //3d ödeme seçeneğe bırakılmışsa seçili, değiştirilebilir yap ve göster
	                        else if (d.tdsState == 'optional') 
		                    {
	                            $('#tds').attr('checked', 'checked');
	                            $('#tds').removeAttr('disabled', 'disabled');
	                            $('#isTds').show();
	                        }
	

	                    } 
	                    else 
	                    {	
	                        //taksit seçeneklerini gizle
	                        $('.installment-table').hide();
	                        $('#isTds').hide();
	                    }
	                });
	
	            
		            //Taksit tablosundan seçim sonucu tetiklenir ve seçilen taksit oranına ait data-key verisi installmentKey' e değer olarak atanır.
		            $('.installment-table').delegate('tr', 'click', function () {
		                var key = $(this).find('input').attr('data-key');
		                $('#installmentKey').val(key);
		            });


        });
    </script>

  
</head>
<body>
	<div class="alert alert-danger" style="display: none;"></div>
	
	<form action="DemoChargeServer.php" method="post" name="checkout-form" id="checkout-form">
			
			
		<table>
			<tr>
				<td>Tutar: </td>
				<td><input type="text" name="amount" maxlength="16" id="amount" data-paynet="amount" value="<?php echo $_SESSION['amount']; ?>" disabled/></td>
			</tr>

		
			<tr>
				<td>Kart Üzerindeki İsim: </td>
				<td><input type="text" name="cardHolderName" id="cardHolderName" data-paynet="holderName" value="" /></td>
			</tr>
			
			
			<tr>
				<td>Kart Numarası: </td>
				<td><input type="text" name="cardNumber" maxlength="16" id="cardNumber" data-paynet="number" value="" /></td>
			</tr>
			
			<tr>
				<td>Son kullanma tarihi ( ay / yıl ): </td>
				<td>
					<select name="expMonth" id="expMonth" data-paynet="exp-month">
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
	                       
	                 <select name="expYear" id="expYear" data-paynet="exp-year">
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
			
			<tr>
				<td>CVV: </td>
				<td><input type="password" maxlength="4" name="cvv" id="cvv" data-paynet="cvv" value="" /></td>
			</tr>
			
			
			<tr>
				<td></td>
				<td>
	                       <div id="isTds" style="display: none;">
	                            <label>
	                                <input type="checkbox" name="tds" id="tds" data-paynet="do3D" checked="checked" />
	                                3D Ödeme
	                            </label>
	                        </div>
	
	                        <div class="installment-table" style="display: none;">
	                        </div>
				</td>
			</tr>
			
			
			<tr>
				<td></td>
				<td>
			
					<button type="submit" data-paynet="submit">Öde</button>
				</td>
			</tr>		
			
		</table>
	</form>


</body>
</html>
