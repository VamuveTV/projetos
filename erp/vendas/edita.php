<?php
session_start();
	
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
<link href="../css/select2.css" rel="stylesheet"/>
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
<script src="../js/select2.js"></script>
<script type="text/javascript">
	$.post('busca_limite.php',{cliente: <?php echo $dados['cliente'];?>}, function(dados){
		$('#area_limite').html("<br><b>Limite disponível:</b> R$ " + dados);		
	  })

	$('#adicionar').click(function(){
		var venda = $("#input-cod").val();
		var produto = $("#input-produto").val();
		var preco = $("#input-preco").val();
		var quantidade = $("#input-quantidade").val();
		
		$('.loader').show();
		$.ajax({//método ajax
			url: "ajax_inclui.php", //página requisitada
			type: "POST",
			data: {venda: venda, produto: produto, preco : preco, quantidade: quantidade},
			success: function(retorno){ //em caso de sucesso
				//limpando os campos e mostrando os produtos
				$('.loader').hide();
				$("#input-preco").val('');
				$("#input-quantidade").val('');
				chamaProdutos(venda);
				atualizaTotal();
				$("#input-produto").select2("open");
			},
			error: (function(retorno) {
				$('.loader').hide();
                fecha();
                $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                chamaTabela();

			})
		});



	})
	$("#input-produto").on("change", function(e) {
		var produto = $(this).val();
		$.post('busca_preco.php',{produto: produto}, function(dados){
			$('#input-preco').val(dados);		
		  })
	})
	
	$("#input-data").mask("99/99/9999");
	$('.input-valor').maskMoney({decimal:",",thousands:"."});
	

	function atualizaTotal(){
		$.post("atualiza_total.php",{cod: <?php echo $_POST['cod']; ?>},
					function(retorno){
						$('#input-total').val(retorno);
					}
		)
	}
  
	atualizaTotal();
	$("#input-cliente").select2();

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



	$("#input-produto").select2("open");

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
			
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaTabela()">Fechar</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="novo()"><i class="icon-plus"></i> Nova</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="pagamentos(<?php echo $_POST['cod']; ?>)"><i class="icon-ok"></i> Receber Pagamentos</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="window.open('carne.php?venda=<?php echo $_POST['cod'];?>','Carnê')"><i class="icon-print"></i> Imprimir carnê</button>
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaRecebimentos('<?php echo $dados['cliente'];?>')"><i class="icon-list-alt"></i> Histórico de compras</button>
			<button class="btn btn-small" style="float: right" onclick="janelaResumo()"><i class="icon-th-list"></i> Resumo</button>
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

    	</div>
		</div>
	</div>
	
	
	<div class="control-group">
	  <label class="control-label" for="input-cliente">Observação</label>
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
		<input id="input-quantidade" tabindex="6" name="input-quantidade" class="input-small" type="text">
		<button type="submit" tabindex="7" id="adicionar" class="btn btn-primary">Adicionar</button>
	  </div>
	</div>
</form>
<script type="text/javascript">
$(".chosen-select").chosen({width: "95%"});
</script>