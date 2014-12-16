<?php
/*
$date = new DateTime('2013-10-05');
$date->modify('+1 month');
echo $date->format('Y-m-d');
 * 
 */

for($i = 1; $i <= $_GET['parcelasC']; $i++){

	echo $_GET['dataC'];
	echo '<br>';	

	//alterando a proxima data de vencimento
	$date = new DateTime($_GET["dataC"]);
	$date->modify('+1 month')	;
	$_GET["dataC"] = $date->format('Y-m-d');
}
?>