<?php
session_start();

mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");

/*
mysql_connect("localhost","root","");

mysql_select_db("agendamento");
*/

if(isset($_POST['acao'])){
  if($_POST['senha'] == 'AC2014'){
    $_SESSION['ok'] = 1;
    header("location: cadastro.php");
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
    <title>Acesso</title>

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
    <h2>Acesso</h2>
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
  </form>
  
  
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    
  
  </body>
</html>