<?php
session_start();
include 'PaynetClass.php';

try{
	//Paynet secret keyi nesneye aktar
	$paynet = new PaynetClient("Buraya secret key değeri girilecektir");

	//Servisin parametrelerini ayarla
	$params = new RatioParameters();
	$params->bin = $_REQUEST["cardBin"];
	$params->amount = PaynetTools::FormatWithoutDecimalSeperator($_SESSION["amount"]);

	//Servisi çalıştır
	$result = $paynet->GetRatios($params);

	if($result->code != ResultCode::successful)
	{
		die("Taksitler getirilirken bir hata oluştu:".$result->message);
	}
	else if(count($result->data) != 1)
	{
		die("Beklenen sayıdan farklı sayıda banka geldi.");
	}
	else
	{
		$bank = $result->data[0];
		PrintInstalments($bank);
	}
}
catch (PaynetException $e)
{
	die($e->getMessage());
}


function PrintInstalments($bank)
{
	echo(
	'<table>
		<tr>
			<td colspan="3"><img src="'.$bank->bank_logo.'" /></td>
		</tr>');

		foreach ($bank->ratio as $ratioItem)
		{
			echo(
			'<tr>
				<td><input type="radio" name="instalment-item" value="'.$ratioItem->instalment.'"/></td>
				<td>'.$ratioItem->desc.'</td>
				<td>'.$ratioItem->instalment_amount.' TL</td>
			</tr>');
		}

	echo(
	'</table>');
}
?>
