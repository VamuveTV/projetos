<?php
session_start();

if(!isset($_SESSION['ok']))
  header('location: index.php');
  
include('bd.php');

if(isset($_POST['acao'])){
  if(isset($_GET['mae'])){ //verificando se é sub-categoria
    $mae = $_GET['mae'];
    $tipo = 'S';
  }
  else{
    $mae = null;
    $tipo = 'C';
  }
  
  if($_POST['acao']=='Gravar')
  {
    if($_FILES["foto"]['name']){
      $target_dir = "icones/";
      $target_dir = $target_dir . basename( $_FILES["foto"]["name"]);
      $foto = 'admin/'.$target_dir;
      if(move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir))
        $log_foto = 1;
      else
        $log_foto = 0;
    }
    else{
      $target_dia = $foto = '';
      $log_foto = 1;
    }
    
    if ($log_foto == 1) {
        //cadastrando categoria        
        $sql = "INSERT INTO categoria(tipo,nome,icone,mae)VALUES('$tipo','".$_POST['nome']."','$foto','$mae')";
        $result = mysql_query($sql);
        if($result)
          $msg = "Cadastro realizado com sucesso";
        else
          $msg = "Falha ao cadastrar";
    } else {
        $msg = "Falha ao enviar ícone";
    }
  }
  else if($_POST['acao']=='Salvar'){
    if($_FILES["foto"]['name']){
      $target_dir = "icones/";
      $target_dir = $target_dir . basename( $_FILES["foto"]["name"]);
      $foto = 'admin/'.$target_dir;
      if(move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir)){
        $log_foto = 1;
        $comp_sql = ",icone='$foto' ";
      }else
        $log_foto = 0;
    }
    else{
      $target_dia = $foto = $comp_sql = '';
      $log_foto = 1;
    }
    
    if ($log_foto == 1) {
        //alterando categoria        
        $sql = "UPDATE categoria SET nome='".$_POST['nome']."' $comp_sql WHERE id='".$_GET['categoria']."'";
        $result = mysql_query($sql);
        if($result)
          $msg = "Cadastro modificado com sucesso";
        else
          $msg = "Falha ao modificar";
    } else {
        $msg = "Falha ao enviar ícone";
    }
  
  }  
}

$categoria = isset($_GET['categoria'])?$_GET['categoria']:'';
if($categoria){ //editar categoria
  $sql = "SELECT nome FROM categoria WHERE id='$categoria'";
  $result = mysql_query($sql);
  list($nome)=mysql_fetch_row($result);
  
  $acao = 'Salvar';
}
else
  $acao = 'Gravar';

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
      width: 950px;
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
    <h2>Cadastrar Categoria</h2>
    <a href="index.php" class="btn btn-success">Voltar</a><br><br>
    <form role="form" method="post" enctype="multipart/form-data">

    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" required class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" placeholder="Nome da categoria">
    </div>
    
    <div class="form-group">
      <label for="nome">Ícone</label>
      <input type="file" class="form-control" id="foto" name="foto">
      <p class="help-block">Arquivo .gif, .jpg ou .png</p>
    </div>
    
    <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
    <input type="submit" name="acao" value="<?php echo $acao; ?>" class="btn btn-primary">
    
    </form>
    <?php
    echo isset($msg)?"<p>$msg</p>":'' ;
    ?>
  </div>
  </body>
</html>
