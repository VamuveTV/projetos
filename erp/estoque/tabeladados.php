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
<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th colspan="8">
		  	Entradas / Saídas
		  	<button class="btn btn-small" style="float: right" onclick="chamaResumo(1)"><i class="icon-th-list"></i> Resumo</button>
		  </th>
	  </tr>
	  <tr>
		  <th>Produto</th>
          <th>Marca</th>
          <th>Cor</th>
          <th>Tamanho</th>
          <th>Unidade</th>
          <th>Quantidade</th>
		  <th>Centro de custo</th>
          <th>Valor custo</th>
		  <th>Valor venda</th>
		  <th>Ações</th>
	  </tr>
      <tr>
          <th><input type="text" id="buscaProduto" class="campo_busca" value="<?php echo $_POST['produto'];?>"></th>
          <th><input type="text" style="width: 40px" id="buscaMarca" class="campo_busca" value="<?php echo $_POST['marca'];?>"></th>
          <th><input type="text" style="width: 40px" id="buscaCor" class="campo_busca" value="<?php echo $_POST['cor'];?>"></th>
          <th><input type="text" style="width: 40px" id="buscaTamanho" class="campo_busca" value="<?php echo $_POST['tamanho'];?>"></th>
          <th><input type="text" style="width: 40px" id="buscaUnidade" class="campo_busca" value="<?php echo $_POST['unidade'];?>"></th>
          <th></th>
          <th><input type="text" style="width: 40px" id="buscaCentro_custo" class="campo_busca" value="<?php echo $_POST['centro_custo'];?>"></th>
          <th></th>
          <th></th>
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

        /*
		$sql = "SELECT e.codigo, p.nome, e.quantidade, e.tipo, e.centro, e.unitario, e.unitario_venda, e.data
				FROM produtos AS p INNER JOIN estoque AS e ON p.codigo=e.produto
				ORDER BY e.data DESC ";
        */
          $sql = "SELECT e.codigo, p.nome, gp.marca, c.nome AS cor, t.nome AS tamanho, u.nome AS unidade, e.quantidade, e.tipo, e.centro, e.unitario, e.unitario_venda";
          $sql .= " FROM produtos AS p, estoque AS e, unidades AS u, grupo_produtos AS gp, cores AS c, tamanhos AS t WHERE p.codigo=e.produto AND u.codigo=e.unidade AND p.grupo=gp.codigo AND p.tamanho=t.codigo AND p.cor=c.codigo";
            if($_POST['cod'])
              $sql.= " AND e.codigo='".$_POST['cod']."' ";
          if($_POST['produto'])
              $sql.= " AND p.nome LIKE '%".$_POST['produto']."%' ";
          if($_POST['unidade'])
              $sql.= " AND u.nome LIKE '%".$_POST['unidade']."%' ";
          if($_POST['centro_custo'])
              $sql.= " AND e.centro='".$_POST['centro_custo']."' ";
          if($_POST['marca'])
              $sql.= " AND gp.marca LIKE '%".$_POST['marca']."%' ";
          if($_POST['cor'])
              $sql.= " AND c.nome LIKE '%".$_POST['cor']."%' ";
          if($_POST['tamanho'])
              $sql.= " AND t.nome='".$_POST['tamanho']."' ";

        $sql.= " ORDER BY e.codigo, p.nome $aux";
        $res = mysql_query($sql);
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td><?php echo $dados['nome']; ?></td>
        <td><?php echo $dados['marca']; ?></td>
        <td><?php echo $dados['cor']; ?></td>
        <td><?php echo $dados['tamanho']; ?></td>
        <td><?php echo $dados['unidade']; ?></td>
		<td><?php echo $dados['quantidade']; ?></td>
		<td><?php echo $dados['centro']; ?></td>
		<td><?php echo number_format($dados['unitario'],2,",","."); ?></td>
		<td><?php echo number_format($dados['unitario_venda'],2,",","."); ?></td>
		<td align="center" nowrap="">
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
$sql = "SELECT * FROM estoque";
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
