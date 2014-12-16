<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM estoque WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">

    $("#input-data").mask("99/99/9999");
    $('#input-valor').maskMoney({decimal:",",thousands:"."});
    $('#input-venda').maskMoney({decimal:",",thousands:"."});
    $('#input-centro').select2();
    
    $('#input-unidade').select2();

    $(function(){
        $.datepicker.regional['pt-BR'] = {
            closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
            dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

        $('#input-data').datepicker();
    });

</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Entrada de estoque
			<button type="button" class="btn" style="float: right" onclick="chamaTabela(1)">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="input-produto">Produto</label>
	  <div class="controls">
	    <input type="hidden" id="input-produto" name="input-produto" value="<?php echo $dados['produto']; ?>">

			<?php
            $codigo = $dados['produto'];
			$sql = "SELECT nome FROM produtos where codigo=$codigo";
			$result = mysql_query($sql);
			list($nomeP)=mysql_fetch_row($result);


				echo $nomeP;

			?>

	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="input-quantidade">Quantidade</label>
	  <div class="controls">
	    <input id="input-quantidade" name="input-quantidade" value="<?php echo $dados['quantidade'];?>" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="">Centro de custo</label>
	  <div class="controls">
	    <select name="input-centro" id="input-centro" class="input-xlarge">
        <option value="F"<?php echo $dados['centro']=='F'?' selected':''; ?>>Padrão</option>
        <option value="NF"<?php echo $dados['centro']=='NF'?' selected':''; ?>>FG</option>	       
	    </select>	    
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-data">Data</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-data" name="input-data" value="<?php echo converte_data($dados['data'],'usuario');?>" maxlength="10">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-valor">Valor(unitário)</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-valor" name="input-valor" value="<?php echo $dados['unitario']; ?>">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-valor">Valor de venda(unitário)</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-venda" name="input-venda" value="<?php echo $dados['unitario_venda']; ?>">
	  </div>
	</div>

	</fieldset>
</fieldset>

<div class="form-actions">
	<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />
	<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
	<button type="button" id="cancelar" onclick="chamaTabela()" class="btn btn-warning">Cancelar</button>
</div>
</form>