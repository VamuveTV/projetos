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
$(".campo_busca").keypress(function(event) {
  if(event.which == 13)
	chamaTabela2();     
});
</script>
<p><button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button></p>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Código</th>
		  <th>Data</th>
		  <th>Cliente</th>
		  <th>Ações</th>
	  </tr>
	  <tr>
		  <th><input type="text" style="width: 30px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
		  <th><input type="text" id="buscaData" class="campo_busca" value="<?php echo $_POST['data'];?>"></th>
		  <th><input type="text" style="width: 95%"id="buscaCliente" class="campo_busca" value="<?php echo $_POST['cliente'];?>"></th>
		  <th width="180px"></th>
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


        $sql = "SELECT v.codigo, v.data, c.nome AS cliente FROM vendas AS v
				INNER JOIN clientes AS c ON c.codigo=v.cliente WHERE v.codigo > 0 ";
		if($_POST['cod'])
			$sql.= "AND v.codigo='".$_POST['cod']."' ";
		if($_POST['data']){
			$_POST['data'] = converte_data($_POST['data'],'banco');	
			$sql.= "AND v.data='".$_POST['data']."' ";
		}
		if($_POST['cliente'])
			$sql.= "AND c.nome LIKE '%".$_POST['cliente']."%' ";
				
		$sql.= "ORDER BY v.data desc $aux";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) {
			$dados['data'] = converte_data($dados['data'],'usuario'); 
  ?>
	<tr>
		<td width="20" class="center"><?php echo $dados['codigo']; ?></td>
		<td width="60"><?php echo $dados['data']; ?></td>
		<td><?php echo $dados['cliente']; ?></td>
		<td align="center" width="160">												
			<button class="btn btn-info" onclick="edita(<?php echo $dados['codigo']; ?>)">
				<i class="icon-edit icon-white"></i>  
				Editar                                            
			</button>
			<button class="btn btn-danger" onclick="janelaConfirma($(this).val());" value="<?php echo $dados['codigo']; ?>">
				<i class="icon-trash icon-white"></i> 
				Excluir
			</button>
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<?php

//query para ver qual o total de paginas
$sql = "SELECT * FROM vendas";
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