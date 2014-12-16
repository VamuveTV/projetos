<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$hoje = date("Y-m-d");
$hoje2 = date("d/m/Y");

//bucando o total da compra
$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['venda']."'";
$result = mysql_query($query);
list($total)=mysql_fetch_row($result);
?>
<script type="text/javascript">
$("#input-dataC").mask("99/99/9999");
$("#input-dataP").mask("99/99/9999");
$('.input-valor').maskMoney({decimal:",",thousands:"."});
</script>
<?php
if($_POST['forma']=='C'){ //crediario
	//buscando a provavel data de vencimento (data atual + 30 dias)
	$date = new DateTime($hoje);
	$date->modify('+1 month');
	$dataC = $date->format('d/m/Y');
?>
	<span style="display: inline-block;width: 10px;"></span>Parcelas
	<input type="text" tabindex="6" id="input-parcelasC" class="input-small">
	<span style="display: inline-block;width: 10px;"></span>
	Total: <input type="text" tabindex="6" id="input-totalC" value="<?php echo $total;?>" class="input-small input-valor">
	<span style="display: inline-block;width: 10px;"></span>
	Vencimento a partir de: <input type="text" tabindex="6" value="<?php echo $dataC;?>" id="input-dataC" class="input-small">
	<span style="display: inline-block;width: 10px;"></span> <button type="button" tabindex="7" id="adicionar-crediario" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar</button>
<?php
}else if($_POST['forma']=='CC'){
	//buscando a provavel data de vencimento (data atual + 30 dias)
	$date = new DateTime($hoje);
	$date->modify('+1 month');
	$dataC = $date->format('d/m/Y');
?>
	<span style="display: inline-block;width: 10px;"></span>Operadora
	<select name="input-operadoraC" id="input-operadoraC">
		<?php
		$query = "SELECT * FROM operadoras ORDER BY nome ";
		$result = mysql_query($query);
		while(list($codO,$nomeO)=mysql_fetch_row($result)){
			echo "<option value='$codO'>$nomeO</option>";
		}
		?>
	</select>
	<span style="display: inline-block;width: 10px;"></span>
	Total: <input type="text" tabindex="6" id="input-totalC" value="<?php echo $total;?>" class="input-small input-valor">
	<br><br><span style="margin-left: 150px;display: inline-block;width: 10px;"></span>Parcelas
	<input type="text" tabindex="6" id="input-parcelasC" class="input-small">	
	<span style="display: inline-block;width: 10px;"></span>
	Vencimento a partir de: <input type="text" tabindex="6" value="<?php echo $dataC;?>" id="input-dataC" class="input-small">
	<span style="display: inline-block;width: 10px;"></span> <button type="button" tabindex="7" id="adicionar-credito" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar</button>
<?php	
}else{
?>
	<span style="display: inline-block;width: 60px;"></span>
	Valor: <input type="text" tabindex="6" id="input-valorP" value="<?php echo $total;?>" class="input-small input-valor">
	<span style="display: inline-block;width: 60px;"></span>
	Vencimento: <input type="text" tabindex="6" id="input-dataP" value="<?php echo $hoje2;?>" class="input-small">
	<span style="display: inline-block;width: 20px;"></span> 
	<button type="button" tabindex="7" id="adicionar-parcela" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar</button>
<?php
}
?>