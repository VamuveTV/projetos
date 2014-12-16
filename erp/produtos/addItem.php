<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");

	$banco = new ZarbMysql();
	
	
	echo "<tr>";
			echo "<td>"; //TAMANHOS
				echo "<select name='tamanho[]'>";
					echo '<option value=""></option>';
				$query2 = "SELECT codigo,nome FROM tamanhos ORDER BY nome";
				$result2 = mysql_query($query2);
				while(list($codT,$nomeT)=mysql_fetch_row($result2)){
					echo "<option value='$codT'>$nomeT</option>";
				}
				echo "</select>";
			echo "</td>";
			echo "<td>"; //CORES
				echo "<select name='cor[]'>";
					echo '<option value=""></option>';
				$query2 = "SELECT codigo,nome FROM cores ORDER BY nome";
				$result2 = mysql_query($query2);
				while(list($codC,$nomeC)=mysql_fetch_row($result2)){
					echo "<option value='$codC'>$nomeC</option>";
				}
				echo "</select>";
			echo "</td>";
			echo "<td>"; //QUANTIDADE
				echo "	<input type='text' style='width: 20px' name='quantidade[]'>";
			echo "</td>";
            echo  "<td>";
            echo "<select id=\"unidades2[]\" name=\"unidades2[]\" >";
            echo "<option value=\"\"></option>";

            $query2 = "SELECT codigo,nome FROM unidades ORDER BY nome";
            $result2 = mysql_query($query2);
            while(list($codU,$nomeU)=mysql_fetch_row($result2)){
                echo "<option value=\"$codU\">$nomeU</option>";

            }


            echo "</select>";
            echo "</td>";
			echo "<td>";
				echo "<input type='button' class='btn btn-mini btn-primary' id='addItem' value='+'>";
			echo "</td>";
	echo "</tr>";
	
?>