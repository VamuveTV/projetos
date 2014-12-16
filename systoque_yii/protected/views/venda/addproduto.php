<?php
/*
$_SESSION['cb'] 
$_SESSION['nome'] 
$_SESSION['qtd'] 
$_SESSION['valor'] 
 */


foreach($_SESSION['cb'] AS $i => $cb){
	$sub = $_SESSION['valor'][$i] * $_SESSION['qtd'][$i];
	echo '<tr>
			<td>'.$cb.'</td>
			<td>'.$_SESSION['nome'][$i].'</td>
			<td>'.$_SESSION['valor'][$i].'</td>
			<td>'.$_SESSION['qtd'][$i].'</td>
			<td>'.$sub.'</td>
		  </tr>';	
}