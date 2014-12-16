<?php 
session_start();
include("../conectar.php");
?>
<script type="text/javascript">
    $(".campo_busca").keypress(function(event) {
        if(event.which == 13)
            chamaTabela2();
    });
</script>
<p>
	<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
	<button class="btn btn-small" onclick="chamaTabela()"><i class="icon-th-list"></i> Todos</button>
</p>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th style="width: 20px">Código</th>
		  <th style="width: 30px">Data</th>
		  <th style="width: 40px">Origem</th>
		  <th style="width: 340px">Produto</th>
		  <th style="width: 20px">Quantidade</th>		  
		  <th>Observação</th>
		  <th>Autorizar</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
  function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}

          $por_pagina = 10;
          $pagina = $_REQUEST['page'];
          $inicio = ($pagina-1)*$por_pagina;
          if($pagina == "undefined")
              $aux = "";
          else
              $aux = "LIMIT $inicio,$por_pagina";

      $sql = "SELECT t.codigo, t.data, un.nome AS unidade, p.nome AS produto, t.quantidade, t.autorizado, t.observacao FROM transferencia AS t 
      		  INNER JOIN unidades AS un ON un.codigo=t.origem INNER JOIN produtos AS p ON p.codigo=t.produto WHERE t.destino = '".$_SESSION['unidade_usu']."' ";
      $sql.= "ORDER BY t.data DESC";

        //$sql = "SELECT u.codigo, u.nome, u.login, un.nome AS unidade FROM usuarios AS u INNER JOIN unidades AS un ON un.codigo=u.unidade ORDER BY u.nome";
		$res = mysql_query($sql);		
		
		while ($dados = mysql_fetch_array($res)) { 
			$dados['data'] = converte_data($dados['data'], 'usuario');
			$aut = $dados['autorizado']=='N'?'N&atilde;o':'Sim';
			$nome_obs = "obs_".$dados['codigo'];	
		?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['data']; ?></td>
		<td><?php echo $dados['unidade']; ?></td>
		<td><?php echo $dados['produto']; ?></td>
		<td><?php echo $dados['quantidade']; ?></td>
		<td>
			<?php
			if($dados['autorizado']=='')
				echo "<textarea id='$nome_obs' name='$nome_obs'></textarea>";
			else
				echo $dados['observacao'];
			?>				
		</td>
		<td align="center">
			<?php
			if($dados['autorizado']==''){
			?>
				<button class="btn btn-success" onclick="autoriza($(this).val());" value="<?php echo $dados['codigo']; ?>">
					<i class="icon-ok icon-white"></i> 
					Sim
				</button>	
				<button class="btn btn-danger" onclick="nao_autoriza($(this).val());" value="<?php echo $dados['codigo']; ?>">
					<i class="icon-ban-circle icon-white"></i> 
					Não
				</button>
			<?php
			}
			else if($dados['autorizado'] == 'N'){
				echo "Não";
			}
			else{
				echo "Sim";
			}
			?>
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<?php
$sql = "SELECT * FROM usuarios ORDER BY codigo, nome";
$res = mysql_query($sql);
$cont = mysql_num_rows($res);
$por_pagina = 10;
$paginas = ceil($cont/$por_pagina);
?>

<div class="pagination pagination-centered">
    <ul id="botao">
        <li><a id="anterior" href="#">Anterior</a></li>
        <?php

        // Mostrar os links da paginação.
        for($i=1; $i<=$paginas; $i++)
        {
            echo '<li class="pagination" id="'.$i.'"><a href="#">'.$i.'</a></li>';
        }
        ?>
        <input type="hidden" id="teste" />
        <input type="hidden" id="total" value="<?php echo $i - 1; ?>" />
        <li><a id="proximo" href="#">Próximo</a></li>

    </ul>

</div>

