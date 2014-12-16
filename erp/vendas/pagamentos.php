<?php 
header("Content-Type: text/html; charset=ISO-8859-1",true);
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}

$query = "SELECT * FROM vendas WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
$dados['data'] = converte_data($dados['data'],'usuario');
?>
<script type="text/javascript">
	$.post('busca_limite.php',{cliente: <?php echo $dados['cliente'];?>}, function(dados){
		$('#area_limite').html("<br><b>Limite dispon&iacute;vel:</b> R$ " + dados);		
	  })
	  
	$('#adicionar').click(function(){
		var venda = $("#input-cod").val();
		var produto = $("#input-produto").val();
		var preco = $("#input-preco").val();
		var quantidade = $("#input-quantidade").val();

		$.ajax({//método ajax
			url: "ajax_inclui.php", //página requisitada
			type: "POST",
			data: {venda: venda, produto: produto, preco : preco, quantidade: quantidade},
			success: function(retorno){ //em caso de sucesso
				//limpando os campos e mostrando os produtos
				$("#input-preco").val('');
				$("#input-quantidade").val('');
				chamaProdutos(venda);
				atualizaTotal();
			},
			error: (function(retorno) {
                fecha();
                $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                chamaTabela();

			})
		});
	})
	
	$("#input-produto").chosen().change(function(){
		var produto = $(this).val();
		$.post('busca_preco.php',{produto: produto}, function(dados){
			$('#input-preco').val(dados);		
		  })
	});
	
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen({width:"95%"});
    }

	$("#input-data").mask("99/99/9999");
	$("#input-dataP").mask("99/99/9999");
	$("#input-dataC").mask("99/99/9999");	

	function atualizaTotal(){
		$.post("atualiza_total.php",{cod: <?php echo $_POST['cod']; ?>},
					function(retorno){
						$('#input-total').val(retorno);
					}
		)
	}
  
	atualizaTotal();
	$('#input-formaP').focus();
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Formas de pagamento			
			
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaTabela()">Fechar</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="novo()"><i class="icon-plus"></i> Nova</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="edita(<?php echo $_POST['cod'];?>)"><i class="icon-th-large"></i> Produtos</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="window.open('carne.php?venda=<?php echo $_POST['cod'];?>','Carnê')"><i class="icon-print"></i> Imprimir carn&ecirc;</button>
	</legend>
	<fieldset id="address-form">

	<div style="width: 70%; float: left">
	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="input-cliente">Cliente</label>
	  <div class="controls">
		<select id="input-cliente" name="input-cliente" style="width: 320px" tabindex="1">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM clientes ORDER BY nome ";
			$result = mysql_query($sql);
			while(list($codC,$nomeC)=mysql_fetch_row($result)){
				echo "<option value='$codC'";
				echo $dados['cliente']==$codC?' selected':'';
				echo ">$nomeC</option>";
			}
			?>
		</select>
		
		<span style="display: inline-block;width: 50px;"></span>Data
		<div id="datetimepicker" class="input-append date">
	      <input tabindex="2" type="text" data-format="dd/MM/yyyy" class="input-small" value="<?php echo $dados['data'];?>" id="input-data" name="input-data">
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
    	</div>

	</div>
	</div>
	
	
	<div class="control-group">
	  <label class="control-label" for="input-cliente">Observa&ccedil;&atilde;o</label>
	  <div class="controls">
		<textarea tabindex="3" id="input-observacao" name="input-observacao" rows="2" class="input-xlarge"><?php echo $dados['observacao'];?></textarea>
		<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />
		 <button tabindex="4" type="submit" id="salvar" class="btn btn-success">Salvar</button>
		 <p id="area_limite" style="margin-left: 70px"></p>
	   </div>
	</div>
	
	</div>
	<div style="width: 25%; float: right;">
	<h3>Total</h3>
	<input type="text" readonly="readonly" id="input-total" style="height: 60px; background: #fff; font-size: 22px">
	</div>

	<div style=" clear: both"></div>
	
	<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'dd/MM/yyyy',
        language: 'pt-BR'
      });
    </script>
	<hr> 
	<?php
	//buscando parcelas do crediario
	$sql = "SELECT parcelasCred, totalCred, vencimento FROM vendas WHERE codigo='".$_POST['cod']."'";
	$result = mysql_query($sql);
	list($parcelasCred,$totalCred,$vencimento)=mysql_fetch_row($result);
	if($totalCred > 0){
		$vencimento = converte_data($vencimento,"usuario");
		echo '<div class="control-group">
			  <label class="control-label" for="input-formaP">Parcelas no credi&aacute;rio</label>
			  <div class="controls">
				<input type="text" readonly="readonly" value="'.$parcelasCred.'" tabindex="6" id="input-parcelasC" class="input-small">
				<span style="display: inline-block;width: 100px;"></span>
				Total: <input type="text" readonly="readonly" value="'.$totalCred.'" tabindex="6" id="input-totalC" class="input-small">
				<span style="display: inline-block;width: 60px;"></span>
				Vencimento a partir de: <input type="text" readonly="readonly" value="'.$vencimento.'" tabindex="6" id="input-dataC" class="input-small">
				<span style="display: inline-block;width: 20px;"></span> <button type="button" tabindex="10" id="remover-crediario" onclick="removeCrediario('.$_POST['cod'].')" class="btn btn-danger"><i class="icon-minus icon-white"></i> Remover</button>
			  </div>
			</div>';		
	}
				
	//buscando parcelas fora do crediario
	$sql = "SELECT p.codigo, f.nome, p.valor, p.data FROM formas_pagamento AS f INNER JOIN parcelas AS p ON f.sigla=p.forma_pagamento
			WHERE p.venda='".$_POST['cod']."' AND f.sigla <> 'C'";
	$result = mysql_query($sql);
	$sub_total = $totalCred>0?$totalCred:0;
	$ct_parcela = $total = 1;
	if(mysql_num_rows($result)>0)
	{
		while(list($codP,$forma,$valor,$dataP)=mysql_fetch_row($result)){
			$dataP = converte_data($dataP,'usuario');			
			$sub_total+= $valor;
			echo '<div class="control-group">
				  <label class="control-label" for="input-cliente">Forma de pagamento '.$ct_parcela.'</label>
				  <div class="controls">
					<input type="text" readonly="readonly" class="input-medium" style="width: 140px" value="'.$forma.'">
					<span style="display: inline-block;width: 50px;"></span>
					Valor: <input type="text" readonly="readonly" class="input-small" value="'.number_format($valor,2,",",".").'">
					<span style="display: inline-block;width: 50px;"></span>
					Vencimento: <input type="text" readonly="readonly" class="input-small" value="'.$dataP.'">
					<span style="display: inline-block;width: 20px;"></span> <button type="button" tabindex="10" id="remover-parcela" onclick="removeParcela(this.value)" value="'.$codP.'" class="btn btn-danger"><i class="icon-minus icon-white"></i> Remover</button>
				  </div>
				</div>';		
			$ct_parcela++;
		}				
	}

	$query2 = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
	$result2 = mysql_query($query2);
	list($total)=mysql_fetch_row($result2);
	$dif = $total - $sub_total;	
	
	if($sub_total > 0){ //sub-total e valor pendente
		echo '<div class="control-group">';
		echo '<h4 style="margin-left: 370px;"> Total: R$ ' . number_format($sub_total,2,",",".");
		if($dif > 0)
			echo " <span style='color: red'>(pendente: R$ ".number_format($dif,2,",",".").")</span>";
		echo "</h4>";
		echo '</div>';
	}

	if($sub_total < $total){
	?>
	<div class="control-group">
	  <label class="control-label" for="input-formaP">Forma de pagamento <?php echo $ct_parcela; ?></label>
	  <div class="controls">
		<select id="input-formaP" tabindex="5" style="width: 140px" onchange="detalhesForma(this.value,'<?php echo $_POST['cod'];?>')">
			<option></option>			
			<?php
			$sql = "SELECT codigo, nome, sigla FROM formas_pagamento  ";
			if($totalCred > 0)
				$sql .= " WHERE sigla <> 'C' ";
			$result = mysql_query($sql);
			while(list($cod,$nome,$sigla)=mysql_fetch_row($result)){
				echo "<option value='$sigla'>$nome</option>";
			}
			?>
		</select>
		<span id="detalhes_forma">		
		</span>
	  </div>
	</div>
	<?php
	}
	?>
</form>

<script type="text/javascript">
function detalhesForma(forma,venda){
	$.post('detalhes_forma.php',{forma: forma, venda: venda},
			function(conteudo){
				$('#detalhes_forma').html(conteudo);
			})

}
</script>
	