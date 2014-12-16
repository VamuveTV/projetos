<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">

$("#cor").select2();
$("#marca").select2();
$("#tamanho").select2();

</script>
<form name="form_localizar" id="formLocalizar" onsubmit="return false;" class="form-horizontal well ucase" >
<fieldset>
	<legend>Localizar Produtos
	</legend>
	<fieldset id="address-form">

	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="nome" name="nome" placeholder="" class="input-xlarge" type="text">
	  </div>
	</div>

	<!-- COR input-->
	<div class="control-group">
	  <label class="control-label" for="input-cor">Cor</label>
	  <div class="controls">
	    <select id="cor" name="cor" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM cores ORDER BY nome";
			$result = mysql_query($sql);
			while(list($cod,$nome)=mysql_fetch_row($result)){
				echo "<option value='$cod'>$nome</option>";
			}
			?>
		</select>
	  </div>
	</div>

	<!-- MARCA input-->
	<div class="control-group">
	  <label class="control-label" for="marca">Marca</label>
	  <div class="controls">
	    <select id="marca" name="marca" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT nome FROM marca ORDER BY nome";
			$result = mysql_query($sql);
			while(list($nome)=mysql_fetch_row($result)){
				echo "<option value='$nome'>$nome</option>";
			}
			?>
		</select>
	  </div>
	</div>

	<!-- TAMANHO input-->
	<div class="control-group">
	  <label class="control-label" for="tamanho">Tamanho</label>
	  <div class="controls">
	    <select id="tamanho" name="tamanho" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM tamanhos ORDER BY nome";
			$result = mysql_query($sql);
			while(list($cod,$nome)=mysql_fetch_row($result)){
				echo "<option value='$cod'>$nome</option>";
			}
			?>
		</select>
	  </div>
	</div>
        <div class="form-actions">
            <button type="submit" id="localizar" onclick="localizar_Produto2();" class="btn btn-info"><i class="icon-search"></i> Localizar</button>
        </div>
	</fieldset>
</fieldset>
    <?php
    if($_POST["localizar"] == 1)
    { ?>

        <table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
	  	  <th>Código</th>
		  <th width="65%">Nome</th>
          <th>Foto</th>
		  <th></th>
	  </tr>

  </thead>
  <tbody>
    <?php
      $sql = "SELECT p.codigo, p.nome, gp.foto
      FROM produtos AS p, grupo_produtos AS gp WHERE p.codigo > 0 AND p.grupo=gp.codigo ";
      if($_POST['cor'])
        $sql.= "AND p.cor='".$_POST['cor']."' ";
      if($_POST['marca'])
          $sql.= "AND gp.marca LIKE '%".$_POST['marca']."%' ";
      if($_POST['tamanho'])
        $sql.= "AND p.tamanho='".$_POST['tamanho']."' ";
      if($_POST['nome'])
        $sql.= "AND p.nome LIKE '%".$_POST['nome']."%' ";
      $sql.= "ORDER BY p.nome";
      $res = mysql_query($sql);
      while ($dados = mysql_fetch_array($res)) { ?>
  <tr>
      <td class="center"><?php echo $dados['codigo']; ?></td>
      <td><?php echo $dados['nome']; ?></td>
      <td><?php echo $dados['foto']; ?></td>
      <td align="center">
          <button class="btn btn-info" onclick="localizar_Produto3(<?php echo $dados['codigo']; ?>)">
              <i class="icon-edit icon-white"></i>
              Selecionar
          </button>


      </td>
  </tr>
  <?php
  }
  ?>
  </tbody>
  </table>
<?php
    }

    ?>

</form>