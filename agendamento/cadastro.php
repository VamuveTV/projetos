<?php
session_start();

if(!isset($_SESSION['ok']))
  header('location: index.php');

/*
mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");
  */

mysql_connect("localhost","root","");

mysql_select_db("agendamento");


if(isset($_GET['e'])){
  $e = $_GET['e'];
  $sql = "DELETE FROM tbl_pontos WHERE id='$e'";
  $result = mysql_query($sql);
  if($result)
    $msq = "Ponto excluido com sucesso";
  else
    $msg = "Falha ao excluir";
}

if(isset($_POST['acao'])){
  $dias = implode("#",$_POST['dias']);
  $sql = "INSERT INTO tbl_pontos VALUES(null,'".$_POST['estado']."','".$_POST['cidade']."','".$_POST['endereco']."','".$_POST['nome']."','".$_POST['telefones']."','".$_POST['email']."','".$dias."','".$_POST['hora_inicio']."','".$_POST['hora_fim']."')";
  $result = mysql_query($sql);
  if($result)
    $msg = "Cadastro realizado com sucesso";
  else
    $msg = "Falha no cadastro";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Pontos</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #tudo{
      width: 750px;
      margin: 50px auto;
      border: 1px #000 solid;
      padding: 10px;
      background-image: url('logo.png');
      background-repeat: no-repeat;
      background-position: top right;
    }
    form{
      width:400px; 
    }
    </style>    
  </head>
  <body>
  <div id="tudo">
    <h2>Cadastro de pontos</h2>
    <form role="form" method="post">
    <div class="form-group">
      <label for="estado">Estado</label>
      <select class="form-control" id="estado" required name="estado">
      <option></option>
      <?php
      $sql = "SELECT uf, nome FROM tb_estados ORDER BY uf";
      $result = mysql_query($sql);
      while(list($uf,$nome)=mysql_fetch_row($result)){
        echo "<option value='$uf'>$nome</option>";
      }
      ?>
      </select>
    </div>
    <div class="form-group">
      <label for="cidade">Cidade</label>
      <span id="combo_cidade">
      <select class="form-control" required id="cidade" name="cidade">
      
      </select>
      </span>
    </div>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" required class="form-control" id="nome" name="nome" placeholder="Digite o nome">
    </div>
    
    <div class="form-group">
      <label for="endereco">Endereço</label>
      <input type="text" required class="form-control" id="endereco" name="endereco" placeholder="Digite o endereço">
    </div>
    
    <div class="form-group">
      <label for="telefones">Telefones</label>
      <input type="text" required class="form-control" id="telefones" name="telefones" placeholder="Digite os telefones">
    </div>
    
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" required class="form-control" id="email" name="email" placeholder="Digite o e-mail">
    </div>
    
    <div class="form-group">
      <label>Dias de atendimento</label>
      <p>
      <input type="checkbox" name="dias[]" value="Segunda"> Segunda
      <input type="checkbox" name="dias[]" value="Terça"> Terça
      <input type="checkbox" name="dias[]" value="Quarta"> Quarta
      <input type="checkbox" name="dias[]" value="Quinta"> Quinta
      <input type="checkbox" name="dias[]" value="Sexta"> Sexta
      <input type="checkbox" name="dias[]" value="Sábado"> Sábado
      </p>
    </div>
    
    <div class="form-group">
      <label>Horário de início</label>
      <input type="text" required class="form-control" style="width: 100px" id="hora_inicio" name="hora_inicio" placeholder="HH:MM">      
    </div>
    
    
    <div class="form-group">
      <label>Horário de término</label>
      <input type="text" required class="form-control" style="width: 100px" id="hora_fim" name="hora_fim" placeholder="HH:MM">      
    </div>
    
    
    <button type="submit" name="acao" class="btn btn-primary">Cadastrar</button>
    <br>
    <?php
    if(isset($msg))
      echo "<p><b>$msg</b></p>";
    ?>
  </form>
  
  <hr>
  <table class="table table-bordered">
  <tr>
    <th>UF</th>
    <th>Cidade</th>
    <th>Nome</th>
    <th>Endereço</th>
    <th>Excluir</th>
  </tr>
  <?php
  $sql = "SELECT p.id,c.nome, p.uf, p.nome, p.endereco FROM tbl_pontos AS p, tb_cidades AS c WHERE c.id=p.cidade ORDER BY p.uf, c.nome ";
  $result = mysql_query($sql);
  while(list($cod,$nome_cidade,$uf,$nome_ponto,$endereco)=mysql_fetch_row($result)){
    echo "<tr>
          <td>$uf</td>
          <td>$nome_cidade</td>
          <td>$nome_ponto</td>
          <td>$endereco</td>
          <td align='center'><a href='cadastro.php?e=$cod' style='color: red'><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>";
  }
  ?>
  </table>
  
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script>
    $(document).ready(function(){
      $('#telefones').mask('(99)99999999?')
      $('#estado').change(function(){
        uf = $(this).val();
        
        $.post('busca_cidade.php',{uf: uf},
          function(dados){
            
            $('#combo_cidade').html(dados);
          }
        )
      })
    })
    </script>
  </body>
</html>