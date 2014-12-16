<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">
$("#input-dataini").mask("99/99/9999");
$("#input-datafim").mask("99/99/9999");
$('#input-preco').maskMoney({decimal:",",thousands:"."});
$('#input-produto').select2();
$('#input-unidade').select2();

$(function() {
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


    $( "#input-dataini" ).datepicker({
        defaultDate: "+1w",
        onClose: function( selectedDate ) {
            $( "#input-datafim" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#input-datafim" ).datepicker({
        defaultDate: "+1w",
        OnClose: function( selectedDate ) {
            $( "#input-dataini" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});

</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Promoções
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Unidade -->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Unidade</label>
	  <div class="controls">
	    <select id="input-unidade" name="input-unidade" class="input-xlarge">
	    	<option value=""></option>
	    	<?php
	    	$sql = "SELECT codigo, nome FROM unidades ORDER BY nome";
			$result = mysql_query($sql);
			while(list($codU,$nomeU)=mysql_fetch_row($result)){
				echo "<option value='$codU'>$nomeU</option>";
			}
	    	?>	
	    </select>    
	  </div>
	</div>
	
	<!-- Produto -->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Produto</label>
	  <div class="controls">
	    <select id="input-produto" name="input-produto" class="input-xlarge">
	    	<option value=""></option>
	    	<?php
	    	$sql = "SELECT codigo, nome FROM produtos ORDER BY nome";
			$result = mysql_query($sql);
			while(list($codP,$nomeP)=mysql_fetch_row($result)){
				echo "<option value='$codP'>$nomeP</option>";
			}
	    	?>	
	    </select>    
	  </div>
	</div>
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-dataini">Data de início</label>
	  <div class="controls">
	    <input id="input-dataini" name="input-dataini" placeholder="dd/mm/aaaa" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-datafim">Data de término</label>
	  <div class="controls">
	    <input id="input-datafim" name="input-datafim" placeholder="dd/mm/aaaa" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-preco">Preço</label>
	  <div class="controls">
	    <input id="input-preco" name="input-preco" class="input-small" required="" type="text">
	  </div>
	</div>
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
    <button type="button" id="cancelar" onclick="chamaTabela()" class="btn btn-warning">Cancelar</button>
</div>
</form>