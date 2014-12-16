<?php 
session_start();
include("../conectar.php");
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Código</th>
		  <th>Nome</th>
		  <th>Endereço</th>
		  <th>Telefone</th>
		  <th>E-mail</th>
		  <th>Ações</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT * FROM empresas ORDER BY codigo, nome";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['nome']; ?></td>
		<td><?php echo $dados['endereco']; ?></td>
		<td><?php echo $dados['telefone']; ?></td>
		<td><?php echo $dados['email']; ?></td>
		<td align="center">												
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
<button class="btn btn-large" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>