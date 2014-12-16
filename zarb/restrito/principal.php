<?
session_start();

include("lib.php");
include("classes/zarbmysql.php");

$hoje = date("Y-m-d");

if(!$_SESSION[cod_usu] && $_POST["submit_login"])
{
    extract($_POST);
    $sql = "SELECT u.codigo, u.cliente, u.nome, c.nome FROM usuclientes AS u, clientes AS c WHERE u.email='$login' AND u.senha='$senha' AND u.cliente=c.codigo ";
    $res = mysql_query($sql);
    if(mysql_num_rows($res)>0)
    {
      list($cod_usu,$cliente_usu,$nome_usu,$nome_cliente)=mysql_fetch_row($res);
      $_SESSION[cod_usu]=$cod_usu;
      $_SESSION[nome_usu]=$nome_usu;
      $_SESSION[cliente_usu]=$cliente_usu;
      $_SESSION[cliente_nome]=$nome_cliente;
      $_SESSION[email_usu]=$login;
    }else{
      echo "<script>document.location='../index.php?log=erro'</script>";
    }
}else if(!$_SESSION[cod_usu]){
  echo "<script>document.location='../index.php'</script>";
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>Zarb Solution - administraçăo</title>
  <style type="text/css">
  @import url(style.css); 
  </style>
  <script type="text/javascript" src="script.js"></script>
  <script type="text/javascript" src="../js/lib.js"></script>
  <script type="text/javascript" src="jquery.js"></script> 
  <script src="jquery.maskedinput-1.1.4.js" type="text/javascript"></script> 
  <script type="text/javascript"> 
  $.noConflict( ) 
  jQuery(function($){ 
  $.mask.addPlaceholder("~","[+-]"); 
  $("#data").mask("99/99/9999");
  $("#data2").mask("99/99/9999");
  $("#cpf").mask("999.999.999-99");
  $("#cep").mask("99999-999");   
  $("#phone").mask("(99) 9999-9999");
  $(".phone").mask("(99) 9999-9999");
  $("#tin").mask("99-9999999");
  $("#ssn").mask("999-99-9999"); 
  $("#product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}}); 
  $("#eyescript").mask("~9.99 ~9.99 999"); 
  }); 
  </script> 
  </head>
  <body>
  <div id="topo">
    <div id="topo_left">
      <img src="../img/logo_transp.png" alt="" style="width: 121px;height: 88px;margin-left: 30px;margin-top: 5px" />
    </div>
    <div id="topo_right">
      <h2>Zarb Solution - Solu&ccedil;&otilde;es em TI</h2>
      <b>Empresa: </b><?php echo $_SESSION['cliente_nome'];?><br />
      <b>Usu&aacute;rio: </b><?php echo $_SESSION['nome_usu']." - ".$_SESSION['email_usu'];?><br />
    </div>
  </div>
  <div id="tudo">
  <!--<img src="images/logo_admin.jpg" id="logo" />-->
    <div id="menu">
      <?
      include("menu.php");
      ?>
    </div>
    <?
    if($_GET["centro"])
    {
      echo "<div id=\"conteudo\">";
            include("$_GET[centro]/index.php");
            
      echo "</div>";
    }
    
    ?>
  </div>
  </body>
</html>
