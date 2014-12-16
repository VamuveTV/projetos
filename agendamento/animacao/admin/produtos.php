<?php
session_start();

if(!isset($_SESSION['ok']))
  header('location: index.php');
  
include('bd.php');

if(isset($_POST['acao'])){
  
  if($_POST['acao']=='Gravar')
  {   
    //buscando os dados do produto via webservice
    include('soap.php'); //conexao soap
    $result = $client->call($session, 'catalog_product.info',$_POST['sku'],'','','SKU');
    
    if($result){                                                                                    
      //cadastrando categoria        
      $sql = "INSERT INTO produto(idcategoria,sku)VALUES('".$_GET['categoria']."','".$_POST['sku']."')";
      $res = mysql_query($sql);
      if($res){
        
        $id_prod = mysql_insert_id();
        
        $nome = $result['name'];
        $preco = number_format($result['price'],2,",",".");
        $url = 'http://acdigital.com.br/'.$result['url_path'];
        
        $result2 = $client->call($session, 'catalog_product_attribute_media.list', $_POST['sku'],'','SKU');
        $foto = $result2[0]['url'];
        
        //atualizando o produto
        $sql = "UPDATE produto SET nome='$nome', foto='$foto', preco='$preco', url='$url' WHERE id='$id_prod' ";
        $res = mysql_query($sql);
        
        $msg = "Cadastro realizado com sucesso";
      }else
        $msg = "Falha ao cadastrar";
    }   
  }
  else if($_POST['acao']=='Atualizar'){
    //alterando produto        
    //buscando os dados do produto via webservice
    include('soap.php'); //conexao soap
    $result = $client->call($session, 'catalog_product.info',$_POST['sku'],'','','SKU');
    
    if($result){                                                                                    
      //alterando produto
      $id_prod = $_GET['produto'];
      
      $sku = $_POST['sku']; 
      
      $nome = $result['name'];
      $preco = number_format($result['price'],2,",",".");
      $url = 'http://acdigital.com.br/'.$result['url_path'];
      
      $result2 = $client->call($session, 'catalog_product_attribute_media.list', $_POST['sku'],'','SKU');
      $foto = $result2[0]['url'];
      
      //atualizando o produto
      $sql = "UPDATE produto SET sku='$sku',nome='$nome', foto='$foto', preco='$preco', url='$url' WHERE id='$id_prod' ";
      $res = mysql_query($sql);
      
      $msg = "Cadastro atualizado com sucesso";
    }else
      $msg = "Falha ao cadastrar";   
  }  
}

$produto = isset($_GET['produto'])?$_GET['produto']:'';
if($produto){ //editar produto
  $sql = "SELECT nome, sku FROM produto WHERE id='$produto'";
  $result = mysql_query($sql);
  list($nome,$sku)=mysql_fetch_row($result);
  
  $acao = 'Atualizar';
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
    <h2>Cadastrar Produto</h2>
    <a href="index.php" class="btn btn-success">Voltar</a><br><br>
    <form role="form" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
      <label for="sku">SKU</label>
      <input type="text" required class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>" placeholder="SKU do produto">
    </div>
    
    <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
    <input type="submit" name="acao" value="<?php echo $acao; ?>" id="botao" class="btn btn-primary">
    <span id="bt"></span>
    
    </form>
    <?php
    echo isset($msg)?"<p>$msg</p>":'' ;
    ?>
  </div>
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
   $('#botao').click(function(){
     $('#bt').html('<br><b>Aguarde...</b>');
     $(this).hide();
   })
 })
</script>
