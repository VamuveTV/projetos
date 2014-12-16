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
$('#valor-custo').maskMoney({decimal:",",thousands:"."});
$('#valor-venda').maskMoney({decimal:",",thousands:"."});
$('#input-centro').select2({
    placeholder: "Selecione o centro de custo"
});
$("#unidades").select2({
    placeholder: "Selecione a unidade"
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

</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Entrada de estoque
			<button type="button" class="btn" style="float: right" onclick="chamaTabela(1)">Fechar</button>
            &nbsp;<button type="button" class="btn" style="float: right" onclick="localizar_Produto()"><i class="icon-search"></i> Pesquisa Avançada</button>
	</legend>
	<fieldset id="address-form">
        <div class="control-group">
            <label class="control-label" for="input-cliente">Produtos</label>
            <div class="controls">
                <input style="width: 800px;" id="input-produto" type="hidden" name="input-produto" data-placeholder="Selecione um produto" />

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
        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="valor-custo">Valor de custo</label>
            <div class="controls">
                <input type="text" id="valor-custo" name="valor-custo" class="input-small" required="">
            </div>
        </div>
        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="valor-venda">Valor de venda</label>
            <div class="controls">
                <input type="text" id="valor-venda" name="valor-venda" class="input-small" required="">
            </div>
        </div>
        <table id="itens" class="table table-striped table-bordered bootstrap-datatable datatable">
            <tr>
                <th colspan="4">Unidades:</th>
            </tr>
            <tr>


                <td colspan="4">
                    <select id="unidades" name="unidades" style="width: 100%;" required="" multiple="multiple">
                        <option value=""></option>
                        <?php
                        $query2 = "SELECT codigo,nome FROM unidades ORDER BY nome";
                        $result2 = mysql_query($query2);
                        while(list($codU,$nomeU)=mysql_fetch_row($result2)){
                            echo "<option value=\"$codU\">$nomeU</option>";

                        }
                        ?>

                    </select>
                </td>
            </tr>
            <tr>
                <th>Tamanho</th>
                <th>Cor</th>
                <th>Quantidade</th>
                <th>Lojas</th>
                <th></th>
            </tr>
            <?php
            echo "<tr>";
            echo "<td>"; //TAMANHOS
            echo "<select name='tamanho[]'>";
            $query2 = "SELECT codigo,nome FROM tamanhos ORDER BY nome";
            $result2 = mysql_query($query2);
            while(list($codT,$nomeT)=mysql_fetch_row($result2)){
                echo "<option value='$codT'>$nomeT</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td>"; //CORES
            echo "<select name='cor[]'>";
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
        </table>
        	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" onclick="chamaTabela()" class="btn btn-warning">Cancelar</button>
</div>
</form>