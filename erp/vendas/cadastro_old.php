<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">
$("#input-data").mask("99/99/9999");
$('.input-valor').maskMoney({decimal:",",thousands:"."}); 

$("#input-produto").on("change", function(e) {
	var produto = $(this).val();
	$.post('busca_preco.php',{produto: produto}, function(dados){
		$('#input-preco').val(dados);		
	  })
})

$("#input-cliente").on("change", function(e) {
	var cliente = $(this).val();
	$.post('busca_limite.php',{cliente: cliente}, function(dados){
		$('#area_limite').html("<br />"+dados);
	  })
    $('#historico').html('<button type="button" class="btn" onclick=chamaRecebimentos($("#input-cliente").val())><i class="icon-list-alt"></i> Histórico</button>');

})

$("#input-cliente").select2({
    placeholder: "Selecione um Cliente"
});

$("#input-produto").select2({
    placeholder: "Selecione um Produto"
});

$("#input-cliente").select2("open");

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



$( "#input-data" ).datepicker({
    defaultDate: "+1w"

    });
});


</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Vendas

			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button> &nbsp;
        &nbsp;<button type="button" class="btn" style="float: right" onclick="localizar_Produto()"><i class="icon-search"></i> Pesquisa Avançada</button>
	</legend>
	<fieldset id="address-form">
		
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
				echo "<option value='$codC'>$nomeC</option>";
			}
			?>
		</select>	
		<button class="btn"><i class="icon-plus" onclick="janelaClientes()"></i></button>	
		<span id="historico"></span>

	    </div>
   </div>

        <div class="control-group">
            <label class="control-label" for="input-data">Data</label>
            <div class="controls">
                <div id="datetimepicker" class="input-append date">
                    <input tabindex="2" type="text" value="<?php echo date("d/m/Y");?>" data-format="dd/MM/yyyy" class="input-small" id="input-data" name="input-data">

                </div>
            </div>
        </div>


	<div class="control-group">
	  <label class="control-label" for="input-cliente">Observação</label>
	  <div class="controls">
		<textarea tabindex="3" id="input-observacao" name="input-observacao" rows="2" class="input-xlarge"></textarea>		
	   </div>
	   <p id="area_limite" style="margin-left: 70px"></p>
	</div>
	


	<hr>  
	
	<div class="control-group">
	  <label class="control-label" for="input-cliente">Produto</label>
	  <div class="controls">
		<select id="input-produto" name="input-produto" style="width: 95%" tabindex="4">
			<option value=""></option>
			<?php
			$sql = "SELECT p.codigo, p.nome, p.referencia from produtos AS p ORDER BY p.nome";
            $result = mysql_query($sql);
            while(list($codP,$nomeP,$referenciaP)=mysql_fetch_row($result))
            {
				$sql2 = "SELECT AVG(unitario_venda) FROM estoque WHERE produto='$codP'";
                $result2 = mysql_query($sql2);
				list($preco)=mysql_fetch_row($result2);
				$precoP = number_format($preco,2,",",".");
				if($_POST["localizar"] == 1)
                {
                    if(($preco > 0) and ($codP == $_POST["codigo"]))
                        echo "<option value='$codP' selected>$nomeP - $referenciaP - R$ $precoP</option>";
                }
                if($preco > 0)
					echo "<option value='$codP'>$nomeP - $referenciaP - R$ $precoP</option>";
			}
			?>
		</select>
		<button class="btn"><i class="icon-plus" onclick="janelaProdutos()"></i></button>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="input-cliente">Quantidade</label>
	  <div class="controls">
		<input id="input-preco" name="input-preco" class="input-small" type="hidden">
		<input id="input-quantidade" tabindex="5" name="input-quantidade" class="input-small" type="text">
		<button type="submit" tabindex="6" id="cadastrar" class="btn btn-primary">Adicionar</button>
	  </div>
	</div>

	</fieldset>
</fieldset>
</form>