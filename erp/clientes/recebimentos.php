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
$("#buscaData").mask("99/99/9999");
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
			Histórico de compras
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaTabela()">Fechar</button>
		</th>
	  </tr>
	  <tr>
		  <th>Venda</th>
		  <th>Data</th>
		  <th>Valor</th>
          <th colspan="3"></th>
	  </tr>
  </thead>   
  <tbody>
  <?php

      $sql = "SELECT p.codigo AS parcela, v.codigo AS venda, p.data, c.nome AS cliente, p.valor, p.recebido, p.recebimento
                    FROM vendas AS v INNER JOIN clientes AS c ON c.codigo=v.cliente
                    INNER JOIN parcelas AS p ON v.codigo=p.venda WHERE c.codigo='".$_POST['cliente']."' ";
      $sql.= "GROUP BY v.codigo";
      $res = mysql_query($sql);

      while(list($codigo_parcela, $codigo_venda, $data_parcela, $nome_cliente, $valor_parcela, $valor_recebido) = mysql_fetch_array($res))
      {
          $data_parcela = converte_data($data_parcela,'usuario');
       ?>


          <tr>
              <td width="60"><a class="btn"  href="../vendas/index.php?cod=<?php echo $codigo_venda; ?>&tela_edita=1" target="_blank" ><?php echo $codigo_venda; ?></a></td>
              <td><?php echo $data_parcela; ?></td>
              <td><?php echo number_format($valor_parcela,2,",","."); ?></td>
              <td colspan="3"><?php echo "<a class='btn' onclick='$(\".$codigo_venda\").slideToggle(100);' >Detalhes</a>"; ?></td>

          </tr>



          <tr class="<?php echo $codigo_venda; ?>" style="display: none">
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
				INNER JOIN parcelas AS p ON v.codigo=p.venda WHERE c.codigo='".$_POST['cliente']."' and v.codigo=$codigo_venda ";
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
		<tr class="<?php echo $codigo_venda; ?>" style="display: none">
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