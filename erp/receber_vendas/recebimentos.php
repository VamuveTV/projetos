<?php 
session_start();
include("../conectar.php");
function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
?>
<script type="text/javascript">
$("#buscaCpf").mask("999.999.999-99");
$(".input-data").mask("99/99/9999");
$(".campo_busca").keypress(function(event) {
  if(event.which == 13)
	chamaTabela2();     
});

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



    $( ".input-data" ).datepicker({
        defaultDate: "+1w"

    });
});

</script>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		<th colspan='5'>
			Receber Vendas
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaTabela()">Fechar</button>
		</th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Nome Cliente</th>
		  <th>CPF</th>
          <th colspan="3"></th>
	  </tr>
      <tr>
          <th><input type="text" style="width: 30px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
          <th><input type="text" id="buscaNome" class="campo_busca" value="<?php echo $_POST['nome'];?>"></th>
          <th><input type="text" id="buscaCpf" class="campo_busca" value="<?php echo $_POST['cpf'];?>"></th>
          <th colspan="3"></th>
      </tr>

  </thead>   
  <tbody>
  <?php

  $por_pagina = 10;
  $pagina = $_REQUEST['page'];
  $inicio = ($pagina-1)*$por_pagina;
  if($pagina == "undefined")
      $aux = "";
  else
      $aux = "LIMIT $inicio,$por_pagina";

      $sql = "SELECT DISTINCT(c.codigo), c.nome, c.cpf FROM clientes AS c, vendas AS v, parcelas AS p WHERE c.codigo=v.cliente AND v.codigo=p.venda AND p.recebido='N' ";
      if($_POST['cod'])
        $sql.= "AND c.codigo='".$_POST['cod']."' ";
      if($_POST['nome'])
        $sql.= "AND c.nome LIKE '%".$_POST['nome']."%' ";
      if($_POST['cpf'])
        $sql.= "AND c.cpf LIKE '%".$_POST['cpf']."%' ";
      $sql.= "ORDER BY c.nome $aux";


      $res = mysql_query($sql);

      while(list($codigo_cliente, $nome_cliente, $cpf) = mysql_fetch_array($res))
      {

       ?>


          <tr>
              <td width="60"><?php echo $codigo_cliente; ?></a></td>
              <td><?php echo $nome_cliente; ?></td>
              <td><?php echo $cpf; ?></td>
              <td colspan="3"><?php echo "<a class='btn' onclick='$(\".$codigo_cliente\").slideToggle(100);' >Detalhes</a>"; ?></td>

          </tr>



          <tr class="<?php echo $codigo_cliente; ?>" style="display: none">
              <th>Código</th>
              <th>Venda</th>
              <th>Data</th>
              <th>Valor</th>
              <th>Valor atual</th>
              <th>Recebimento</th>
          </tr>
         <?php
        $sql2 = "SELECT p.codigo AS parcela, v.codigo AS venda, p.data, c.nome AS cliente, p.valor, p.recebido, p.recebimento
				FROM vendas AS v INNER JOIN clientes AS c ON c.codigo=v.cliente 
				INNER JOIN parcelas AS p ON v.codigo=p.venda WHERE c.codigo='".$codigo_cliente."'";
		$sql2.= "ORDER BY p.data desc";
        $res2 = mysql_query($sql2);
		while ($dados2 = mysql_fetch_array($res2)) {
			$id_campo = 'id_' . $dados2['parcela'];
			if($dados2['recebido'] == 'S')
				$dados2['recebimento'] = converte_data($dados2['recebimento'],'usuario');
			else
				$dados2['recebimento'] = '';
			
			//calculando os juros (2% + 0,33% ao dia)
			$hoje = date("Y-m-d");
			$time_inicial = strtotime($dados2['data']);
			$time_final = strtotime($hoje);
			
			if($time_final > $time_inicial){
				$sql3 = "SELECT DATEDIFF('$hoje','".$dados2['data']."')";
				$res3 = mysql_query($sql3);
				list($dias)=mysql_fetch_row($res3);
				
				//calculando o valor
				$multa = $dados2['valor'] * 0.02;
				$juros = $dados2['valor'] * 0.0033;
				$valor_atual = ($multa) + ($juros * $dias);
				$valor_atual+= $dados2['valor'];
			}
			else
				$valor_atual = $dados2['valor'];
				 
			$dados2['data'] = converte_data($dados2['data'],'usuario');
  ?>
		<tr class="<?php echo $codigo_cliente; ?>" style="display: none">
			<td width="20" class="center"><?php echo $dados2['parcela']; ?></td>
			<td width="60"><a class="btn"  href="../vendas/index.php?cod=<?php echo $dados2['venda']; ?>&tela_edita=1" target="_blank" ><?php echo $dados2['venda']; ?></a></td>
			<td><?php echo $dados2['data']; ?></td>
			<td><?php echo number_format($dados2['valor'],2,",","."); ?></td>
			<td><?php echo number_format($valor_atual,2,",",".");?></td>
			<td align="center" width="200">												
				<input type="text" id="<?php echo $id_campo;?>" class="input-small input-data" value="<?php echo $dados['recebimento'];?>">	
				<?php
				if($dados2['recebido']=='N')
					echo "<button class=\"btn btn-mini btn-success\" onclick=\"recebe_pag('#$id_campo','".$_POST['cliente']."')\">Receber</button>";
				else
					echo "<button class=\"btn btn-mini btn-danger\" onclick=\"exclui_pag('#$id_campo','".$_POST['cliente']."')\">Remover</button>";
				?>
			</td>
		</tr>
	<?php
	}

      }
	?>
	
	
  </tbody>
  </table>
<?php

//query para ver qual o total de paginas
$sql = "SELECT DISTINCT(c.codigo), c.nome, c.cpf FROM clientes AS c, vendas AS v, parcelas AS p WHERE c.codigo=v.cliente AND v.codigo=p.venda AND p.recebido='N' order by c.nome";
$res = mysql_query($sql);
$cont = mysql_num_rows($res);
$cont = ceil($cont / 10);

?>

<div class="pagination pagination-centered">
    <ul id="botao">
        <?php
        if($pagina != 1)
            echo "<li><a id=\"anterior\" href=\"#\">Anterior</a></li>";

        if($pagina <=3)
            $aux2 = 1;
        else
            $aux2 = $pagina - 3;
        // Mostrar os links da paginação.

        if($pagina != $cont)
            $proximo = "<li><a id=\"proximo\" href=\"#\">Próximo</a></li>";
        else
            $proximo = "";

        $fim = $pagina + 3;

        if($fim >= $cont)
        {
            $fim = $cont;
        }
        for($i=$aux2; $i<=$fim; $i++)
        {

            echo '<li class="pagination" id="'.$i.'"><a href="#">'.$i.'</a></li>';

        }
        ?>
        <input type="hidden" id="teste" />
        <input type="hidden" id="total" value="<?php echo $i - 1; ?>" />
        <?php
        echo $proximo;
        ?>

    </ul>

</div>
