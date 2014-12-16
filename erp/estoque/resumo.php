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
    $(".campo_busca").keypress(function(event) {
        if(event.which == 13)
            chamaResumo();
    });
</script>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th colspan="8">
		  	Resumo
		  	<button class="btn btn-small" style="float: right" onclick="chamaTabela()"><i class="icon-refresh"></i> Entradas / Saídas</button>
		  </th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Produto</th>
		  <th>Quantidade</th>
	  </tr>
      <tr>
          <th><input type="text" style="width: 30px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
          <th><input type="text" id="buscaProduto" class="campo_busca" value="<?php echo $_POST['produto'];?>"></th>
          <th></th>


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

		//$sql = "SELECT codigo, nome FROM produtos ORDER BY nome ";
        $sql = "SELECT p.codigo, p.nome FROM produtos AS p, estoque AS e Where p.codigo=e.produto AND e.quantidade>1 ";
          if($_POST['cod'])
              $sql.= " AND p.codigo='".$_POST['cod']."' ";
          if($_POST['produto'])
              $sql.= " AND p.nome LIKE '%".$_POST['produto']."%' ";
        $sql.= " ORDER BY p.nome $aux";
        $res = mysql_query($sql);
		while (list($codP,$nomeP)=mysql_fetch_row($res)) { ?>
	<tr>
		<td class="center"><?php echo $codP; ?></td>
		<td><?php echo $nomeP; ?></td>
		<td>
			<table>
				<tr>
					<th>Unidade</th>
					<th>Quantidade</th>
				</tr>
				<?php
					//buscando as unidades
					$sql2 = "SELECT codigo, nome FROM unidades ORDER BY nome ";
					$res2 = mysql_query($sql2);
					while(list($codU,$nomeU)=mysql_fetch_row($res2)){
						//buscando a quantidade por unidade
						$sql3 = "SELECT SUM(quantidade) FROM estoque WHERE tipo='E' AND produto='$codP' AND unidade='$codU'";
						$res3 = mysql_query($sql3);
						list($total_entrada)=mysql_fetch_row($res3);
						
						$sql3 = "SELECT SUM(quantidade) FROM estoque WHERE tipo='S' AND produto='$codP' AND unidade='$codU'";
						$res3 = mysql_query($sql3);
						list($total_saida)=mysql_fetch_row($res3);
						
						$total = $total_entrada - $total_saida;
						
						echo "<tr>
								<td>$nomeU</td>
								<td>$total</td>
							  </tr>";
					}
				?>				
			</table>		
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-large" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<?php

//query para ver qual o total de paginas
$sql = "SELECT p.codigo, p.nome FROM produtos AS p, estoque AS e Where p.codigo=e.produto AND e.quantidade>1 ORDER BY nome";
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