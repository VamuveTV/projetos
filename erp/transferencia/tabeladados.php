<?php 
session_start();
include("../conectar.php");
?>
<script type="text/javascript">
    $("#buscaData").mask("99/99/9999");
    $(".campo_busca").keypress(function(event) {
        if(event.which == 13)
            chamaTabela2();
    });
</script>
<p>
	<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
	<button class="btn btn-small" onclick="chamaAutorizar()"><i class="icon-ok"></i> Autorizar</button>
	
</p>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Código</th>
		  <th>Data</th>
          <th>Origem</th>
          <th>Destino</th>
		  <th>Produto</th>
		  <th>Quantidade</th>
		  <th>Autorizado</th>
		  <th>Ações</th>
	  </tr>
      <tr>
          <th><input type="text" style="width: 30px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
          <th style="width: 70px"><input style="width: 70px" type="text" id="buscaData" class="campo_busca" value="<?php echo $_POST['data'];?>"></th>
          <th style="width: 100px"><input type="text" style="width: 100px" id="buscaOrigem" class="campo_busca" value="<?php echo $_POST['origem'];?>"></th>
          <th style="width: 100px"><input type="text" style="width: 100px" id="buscaDestino" class="campo_busca" value="<?php echo $_POST['destino'];?>"></th>
          <th><input style="width: 95%" type="text" id="buscaProduto" class="campo_busca" value="<?php echo $_POST['produto'];?>"></th>
          <th></th>
          <th></th>
          <th></th>
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

          if($_POST['origem'])
              $aux2 = "(select nome from unidades where unidades.codigo=t.origem AND unidades.nome LIKE '%".$_POST['origem']."%' ) AS origem";
          else
              $aux2 = "(select nome from unidades where unidades.codigo=t.origem) AS origem";

      $sql = "SELECT t.codigo, t.data, $aux2, un.nome AS destino, p.nome AS produto, t.quantidade, t.autorizado FROM transferencia AS t
      		  INNER JOIN unidades AS un ON un.codigo=t.destino INNER JOIN produtos AS p ON p.codigo=t.produto WHERE t.origem = '".$_SESSION['unidade_usu']."' ";

      if($_POST['cod'])
          $sql.= "AND t.codigo='".$_POST['cod']."' ";
      if($_POST['data']){
      	  $_POST['data'] = converte_data($_POST['data'], 'banco');
          $sql.= "AND t.data = '".$_POST['data']."' ";
	  }
      if($_POST['destino'])
          $sql.= "AND un.nome LIKE '%".$_POST['destino']."%' ";
      if($_POST['produto'])
          $sql.= "AND p.nome LIKE '%".$_POST['produto']."%' ";
	  if($_POST['quantidade'])
          $sql.= "AND t.quantidade = '".$_POST['quantidade']."' ";
      $sql.= "ORDER BY t.data DESC ";
	  $sql.= $aux;

        //$sql = "SELECT u.codigo, u.nome, u.login, un.nome AS unidade FROM usuarios AS u INNER JOIN unidades AS un ON un.codigo=u.unidade ORDER BY u.nome";
		$res = mysql_query($sql);		
		
		while ($dados = mysql_fetch_array($res)) { 
			$dados['data'] = converte_data($dados['data'], 'usuario');
			$aut = $dados['autorizado']=='N'?'N&atilde;o':'Sim';	
		?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['data']; ?></td>
		<td><?php echo $dados['origem']; ?></td>
        <td><?php echo $dados['destino']; ?></td>
		<td><?php echo $dados['produto']; ?></td>
		<td><?php echo $dados['quantidade']; ?></td>
		<td><?php echo $aut; ?></td>
		<td align="center">	
			<?php
			if($dados['autorizado'] == 'N'){
			?>
			<button class="btn btn-danger" onclick="janelaConfirma($(this).val());" value="<?php echo $dados['codigo']; ?>">
				<i class="icon-trash icon-white"></i> 
				Excluir
			</button>
			<?php
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
$sql = "SELECT * FROM transferencia ";
$res = mysql_query($sql);
$cont = mysql_num_rows($res);
$por_pagina = 10;
$paginas = ceil($cont/$por_pagina);

if($paginas > 1){
?>
<div class="pagination pagination-centered">
    <ul id="botao">        
        <?php       
	        if(isset($_REQUEST['page'])){
	        	if($_REQUEST['page'] != 1)
	        		echo '<li><a id="anterior" href="#">Anterior</a></li>';
	        }
	
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
<?php
}
?>
