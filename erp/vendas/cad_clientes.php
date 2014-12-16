<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">
$("#input-cep").mask("99999-999");
$("#input-telefone").mask("(99)9999-9999");
$("#input-cpf").mask("999.999.999-99");
$("#input-data").mask("99/99/9999");

$("#input-estado").select2();
$("#input-civil").select2();

function buscaCep(cep){
	$('#input-endereco').val('Aguarde...');
	cep = cep.replace("-","");
	$.ajax({
		url: "../clientes/busca_cep.php",
		type: "POST",
		data: {cep : cep},
		success: function(retorno){			
			dados = retorno.split('#');
			$('#input-endereco').val(dados[0]);
			$('#input-cidade').val(dados[1]);
			$('#input-estado option').each(function(){
	           if($(this).val() == dados[2]){
	               $(this).attr('selected',true);
	           }
	       });
		}
	})

}

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

<?php
//buscando as configurações de crediário
$sql = "SELECT maximo_compra, maximo_parcela, parcela_minima FROM config_crediario LIMIT 0,1 ";
$result = mysql_query($sql);
list($maximo_compra,$maximo_parcela,$parcela_minima)=mysql_fetch_row($result);
?>

function mostraLimite(renda){
	var limite = (<?php echo $maximo_compra;?> * renda) / 100;
	$('#input-limite').val(limite); 
}
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Clientes</legend>
	<fieldset id="address-form">
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">E-mail</label>
	  <div class="controls">
	    <input id="input-email" name="input-email" placeholder="" class="input-xlarge" required="" type="email">
	    
	  </div>
	</div>

	<!-- Cep input-->
	<div class="control-group">
	  <label class="control-label" for="">Cep</label>
	  <div class="controls">
	    <input id="input-cep" name="input-cep" placeholder="" onblur="buscaCep(this.value)" pattern="[0-9]{5}(\-[0-9]{3})?" class="input-small" required="" type="text">
	    
	  </div>
	</div>

	<!-- Endereco input-->
	<div class="control-group">
	  <label class="control-label" for="">Endereço</label>
	  <div class="controls">
	    <input id="input-endereco" name="input-endereco" placeholder="" class="input-xlarge" required="" type="text">
	    Número
		<input id="input-numero" name="input-numero" placeholder="" class="input-small" required="" type="text">
	  </div>
	</div>

	<!-- Complemento input-->
	<div class="control-group">
	  <label class="control-label" for="">Complemento</label>
	  <div class="controls">
	    <input id="input-complemento" name="input-complemento" type="text">
	  </div>
	</div>

	<!-- Cidade input-->
	<div class="control-group">
	  <label class="control-label" for="input-cidade">Cidade</label>
	  <div class="controls">
	    <input id="input-cidade" name="input-cidade" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>

	<!-- Estado input-->
	<div class="control-group">
	  <label class="control-label" for="input-estado">Estado</label>
	  <div class="controls">
	    <select name="input-estado" id="input-estado" class="input-xlarge">
			<option>Escolha o Estado</option>
			<option value="AC">Acre</option>
			<option value="AL">Alagoas</option>
			<option value="AP">Amapá</option>
			<option value="AM">Amazonas</option>
			<option value="BA">Bahia</option>
			<option value="CE">Ceará</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espirito Santo</option>
			<option value="GO">Goiás</option>
			<option value="MA">Maranhão</option>
			<option value="MT">Mato Grosso</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MG">Minas Gerais</option>
			<option value="PA">Pará</option>
			<option value="PB">Paraiba</option>
			<option value="PR">Paraná</option>
			<option value="PE">Pernambuco</option>
			<option value="PI">Piauí</option>
			<option value="RJ">Rio de Janeiro</option>
			<option value="RN">Rio Grande do Norte</option>
			<option value="RS">Rio Grande do Sul</option>
			<option value="RO">Rondônia</option>
			<option value="RR">Roraima</option>
			<option value="SC">Santa Catarina</option>
			<option value="SP">São Paulo</option>
			<option value="SE">Sergipe</option>
			<option value="TO">Tocantis</option>
		</select>
	    
	  </div>
	</div>
	
	<!-- Telefone input-->
	<div class="control-group">
	  <label class="control-label" for="input-telefone">Telefone</label>
	  <div class="controls">
	    <input id="input-telefone" name="input-telefone" placeholder="" class="input-xlarge" required="" type="tel">
	  </div>
    </div>

	<!-- Renda input-->
	<div class="control-group">
	  <label class="control-label" for="input-renda">Renda mensal</label>
	  <div class="controls">
	    <input id="input-renda" name="input-renda" onblur="mostraLimite(this.value)" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Limite input-->
	<div class="control-group">
	  <label class="control-label" for="input-limite">Limite de crediário</label>
	  <div class="controls">
	    <input id="input-limite" name="input-limite" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- cpf input-->
	<div class="control-group">
	  <label class="control-label" for="input-cpf">CPF</label>
	  <div class="controls">
	    <input id="input-cpf" name="input-cpf" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Identidade input-->
	<div class="control-group">
	  <label class="control-label" for="input-identidade">Identidade</label>
	  <div class="controls">
	    <input id="input-identidade" name="input-identidade" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Data de nascimento input-->
	<div class="control-group">
	  <label class="control-label" for="input-data">Data de nascimento</label>
	  <div class="controls">
	    <input id="input-data" name="input-data" placeholder="" class="input-small" required="" type="text">
	  </div>
    </div>

	<!-- Conjuge input-->
	<div class="control-group">
	  <label class="control-label" for="input-conjuge">Cônjuge</label>
	  <div class="controls">
	    <input id="input-conjuge" name="input-conjuge" placeholder="" class="input-xlarge" type="text">
	  </div>
    </div>

	<!-- Estado civil input-->
	<div class="control-group">
	  <label class="control-label" for="input-civil">Estado civil</label>
	  <div class="controls">
	    <select name="input-civil" id="input-civil" class="input-xlarge">
			<option value="solteiro">Solteiro</option>
			<option value="casado">Casado</option>
			<option value="divorciado">Divorciado</option>
			<option value="viuvo">Viúvo</option>
		</select>
	  </div>
    </div>
    
    <!-- Observacao input-->
	<div class="control-group">
	  <label class="control-label" for="input-observacao">Observação</label>
	  <div class="controls">
	    <textarea id="input-observacao" name="input-observacao"></textarea>
	  </div>
    </div>

	</fieldset>
</fieldset>

</form>