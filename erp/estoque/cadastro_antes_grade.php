<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">
$("#input-data").mask("99/99/9999");
$('#input-valor').maskMoney({decimal:",",thousands:"."});
$('#input-venda').maskMoney({decimal:",",thousands:"."});
$('#input-centro').select2();
$('#input-produto').select2();
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
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="input-produto">Produto</label>
	  <div class="controls">
	    <select id="input-produto" name="input-produto" class="input-xlarge" required="">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM produtos ORDER BY nome ";
			$result = mysql_query($sql);
			while(list($codP,$nomeP)=mysql_fetch_row($result)){
				echo "<option value='$codP'>$nomeP</option>";
			}
			?>
		</select>
	  </div>
	</div>

	<!-- Unidade input-->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Unidade</label>
	  <div class="controls">
	    <select id="input-unidade" name="input-unidade" class="input-xlarge" required="">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM unidades ORDER BY nome ";
			$result = mysql_query($sql);
			while(list($codU,$nomeU)=mysql_fetch_row($result)){
				echo "<option value='$codU'>$nomeU</option>";
			}
			?>
		</select>
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="input-quantidade" >Quantidade</label>
	  <div class="controls">
	    <input id="input-quantidade" name="input-quantidade" placeholder="" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="">Centro de custo</label>
	  <div class="controls">
	    <select name="input-centro" id="input-centro" class="input-xlarge">
        <option value="F">Padrão</option>
        <option value="NF">FG</option>	       
	    </select>
	    
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-data">Data</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-data" name="input-data" maxlength="10">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-valor">Valor de custo(unitário)</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-valor" name="input-valor">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-valor">Valor de venda(unitário)</label>
	  <div class="controls">
	    <input type="text" class="input-small" id="input-venda" name="input-venda">
	  </div>
	</div>

	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" onclick="chamaTabela()" class="btn btn-warning">Cancelar</button>
</div>
</form>