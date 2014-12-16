<?php
session_start();

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
            var caminho = "../produtos/fotos/" + movie.foto;
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
$("#unidade-destino").select2({
    placeholder: "Selecione a unidade que deseja solicitar a transferência"
});


$(document).ready(function(){
    $('#produto').select2({
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
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Transferência de estoque
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Unidade -->
	<div class="control-group">
	  <label class="control-label" for="unidade-destino">Unidade de origem</label>
	  <div class="controls">
	    	<?php
	    	$sql = "SELECT nome FROM unidades WHERE codigo='".$_SESSION['unidade_usu']."'";
			$result = mysql_query($sql);
			list($nomeU)=mysql_fetch_row($result);
				echo "<input type='text' value='$nomeU' readonly='readonly'>";
				
	    	?>	  
	  </div>
	</div>
	
	<!-- Unidade -->
	<div class="control-group">
	  <label class="control-label" for="unidade-destino">Unidade que fonecerá o produto</label>
	  <div class="controls">
	    <select id="unidade-destino" name="unidade-destino" class="input-xlarge" style="width: 600px">
	    	<option value=""></option>
	    	<?php
	    	$sql = "SELECT codigo, nome FROM unidades WHERE codigo<>'".$_SESSION['unidade_usu']."' ORDER BY nome";
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
            <label class="control-label" for="input-cliente">Produtos</label>
            <div class="controls">
                <input style="width: 800px;" id="produto" type="hidden" name="produto" data-placeholder="Selecione um produto" />

            </div>

        </div>
		
	<!-- Quantidade -->
	<div class="control-group">
	  <label class="control-label" for="quantidade">Quantidade</label>
	  <div class="controls">
	    <input id="quantidade" name="quantidade" placeholder="" class="input-small" required="" type="text">	    
	  </div>
	</div>
	
	<!-- Observacao -->
	<div class="control-group">
	  <label class="control-label" for="observacao">Observação</label>
	  <div class="controls">
	    <textarea id="observacao" name="observacao" class="input-xlarge"></textarea>	    
	  </div>
	</div>
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>