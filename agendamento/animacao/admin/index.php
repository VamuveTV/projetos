<?php
session_start();

include('bd.php');

if(isset($_POST['acao'])){
  if($_POST['senha'] == 'AC2014'){
    $_SESSION['ok'] = 1;
  }
  else
    $msg = "Senha inválida";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #tudo{
      width: 1050px;
      margin: 100px auto;
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
    <h2>Administrador</h2>
    <?php
    if(!isset($_SESSION['ok']))
    {
    ?>
    <form role="form" method="post">
    <div class="form-group">
      
    <div class="form-group">
      <label for="senha">Senha</label>
      <input type="password" required class="form-control" id="senha" name="senha" placeholder="******">
    </div>
    
    
    <button type="submit" name="acao" class="btn btn-primary">Acessar</button>
    <br>
    <?php
    if(isset($msg))
      echo "<p><b>$msg</b></p>";
    ?>
    </div>
    </form>
    <?php
     }
     else
     {
     ?>
     <a href="categorias.php" class="btn btn-danger">Nova Categoria</a><br><br>
     <table class="table table-bordered table-striped">
     <tr>
      <th>Nome</th>
      <th>Sub-Categorias</th>
      <th>Produtos</th>
     </tr>
     <?php
     $sql = "SELECT id, tipo, nome, icone, mae FROM categoria ORDER BY mae, nome ";
     $result = mysql_query($sql);
     while(list($id_cat,$tipo_cat,$nome_cat,$icone_cat,$mae_cat)=mysql_fetch_array($result)){
        //buscando subcategorias
        $sql2 = "SELECT id, tipo, nome, icone FROM categoria WHERE mae='$id_cat' ORDER BY nome ";
        $result2 = mysql_query($sql2);
        //buscando produtos
        $sql3 = "SELECT id, nome, sku FROM produto WHERE idcategoria='$id_cat' ORDER BY nome ";
        $result3 = mysql_query($sql3);
        echo "<tr>";
          echo "<td><a href='categorias.php?categoria=$id_cat'>$nome_cat</a></td>";
          //listando subcategorias          
          echo "<td>";
            //exibe produtos somente se não existem sub-produtos
            if(mysql_num_rows($result3)==0)
            {
              if($tipo_cat == 'C')
                echo "<a href='categorias.php?mae=$id_cat' class='btn btn-primary'>Nova sub-categoria</a><br>";
              
              echo mysql_num_rows($result2)>0?'<ul>':'';
              while(list($id_sub,$tipo_sub,$nome_sub,$icone_sub)=mysql_fetch_row($result2)){
                echo "<li><a href='categorias.php?categoria=$id_sub&mae=$id_cat'>$nome_sub</a></li>";
              }
              echo mysql_num_rows($result2)>0?'</ul>':'';
            }            
          echo "</td>";
          //listando produtos
          echo "<td>";
            //exibe produtos somente se não existem sub-categorias
            if(mysql_num_rows($result2)==0)
            {
              echo "<a href='produtos.php?categoria=$id_cat' class='btn btn-success'>Novo produto</a><br>";
              
              echo mysql_num_rows($result3)>0?'<ul>':'';    
              while(list($id_prod,$nome_prod,$sku_prod)=mysql_fetch_row($result3)){
                echo "<li><a href='produtos.php?produto=$id_prod'>$nome_prod</a></li>";
              }
              echo mysql_num_rows($result3)>0?'</ul>':'';
            }    
          echo "</td>";
        echo "</tr>"; 
     }
     ?>
     </table>
     
     
     <?php
     }
    ?>
    
    
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    
    
  
  </body>
</html>