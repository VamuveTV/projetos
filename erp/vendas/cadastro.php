<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<style type="text/css">
    .movie-result td {vertical-align: top }
    .movie-image { width: 60px; }
    .movie-image img { height: 80px; width: 60px;  }
    .movie-info { padding-left: 10px; vertical-align: top; }
    .movie-title { font-size: 1.2em; padding-bottom: 15px; }
    .movie-synopsis { font-size: .8em; color: #888; }
    .select2-highlighted .movie-synopsis { font-size: .8em; color: #eee; }
    .bigdrop.select2-container .select2-results {max-height: 300px;}
    .bigdrop .select2-results {max-height: 300px;}
</style>
<script src="../js/select2.js"></script>
<script>

    function movieFormatResult(movie) {
        if(movie.foto == undefined)
            var caminho = "../produtos/fotos/images.jpg";
        else
            var caminho = "../fotos/fotos/" + movie.foto;
        var markup = "<table class='movie-result'><tr>";
        //markup += "<td class='movie-image'>"+movie.foto+" <img src=' + "'/></td>";
        markup += "<td class='movie-image'><img src='"+caminho+"' /></td>";

        markup += "<td class='movie-info'><div class='movie-title'>" + movie.text + "</div>";
        if (movie.comentario !== undefined) {
            markup += "<div class='movie-synopsis'>" + movie.comentario + "</div>";
        }
        markup += "</td></tr></table>"
        return markup;
    }

    function movieFormatSelection(movie) {
        return movie.text;
    }

</script>
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

    $(document).ready(function(){
    $('#input-produto').select2({
        placeholder: "Selecione um produto",
        minimumInputLength: 2,
        ajax: {
            url: "busca_produto.php",
            dataType: 'json',
            quietMillis: 100,
            data: function (term, page) {
                return {
                    q: term,
                    page_limit: 10, // page size
                    page: page // page number
                };
            },
            results: function (data, page) {
                if(data == '')
                    var qtd = 0;
                else{
                    var qtd = data[0]['total'];
                    data.splice(0,1);
                }
                var more = (page * 10) < qtd; // whether or not there are more results available
                return { results: data, more: more};
            }
        },
        formatResult: movieFormatResult, // omitted for brevity, see the source of this page
        formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
        escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    });
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

<?php if ($_POST["localizar"] == 1) { ?>
localizar_produto4(<?php echo ($_POST["codigo"]); ?>)
<?php } ?>


</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Vendas

			<button type="button" class="btn" style="float: right" onclick="chamaTabela(1)">Fechar</button> &nbsp;
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
            <label class="control-label" for="input-cliente">Produtos</label>
            <div class="controls">
                <input style="width: 800px;" id="input-produto" type="hidden" name="input-produto" data-placeholder="Selecione um produto" />
                <button class="btn"><i class="icon-plus" onclick="janelaProdutos2(<?php echo $_POST['cod'];?>)"></i></button>
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