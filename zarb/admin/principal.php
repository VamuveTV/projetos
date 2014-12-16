<?
session_start();

include("lib.php");
include("classes/zarbmysql.php");

$hoje = date("Y-m-d");

if(!$_SESSION[cod_admin] && $_POST["submit_login"])
{
    extract($_POST);
    $sql = "SELECT codigo, nome FROM usuarios WHERE email='$login' AND senha='$senha' ";
    $res = mysql_query($sql);
    if(mysql_num_rows($res)>0)
    {
      list($cod_admin,$nome_admin)=mysql_fetch_row($res);
      $_SESSION[cod_admin]=$cod_admin;
      $_SESSION[nome_admin]=$nome_admin;
    }else{
      echo "<script>document.location='index.php?log=erro'</script>";
    }
}else if(!$_SESSION[cod_admin]){
  echo "<script>document.location='index.php'</script>";
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
  <script src="jquery.priceFormat.js" type="text/javascript"></script>
  <script type="text/javascript">
  $.noConflict( )
  jQuery(function($){
  $.mask.addPlaceholder("~","[+-]");
  $(".placa").mask("aaa-9999");
  $(".hora").mask("99:99");
  $(".data").mask("99/99/9999");
  $(".date").mask("99/9999");
  $(".datahora").mask("99/99/9999 99:99");
  $("#cpf").mask("999.999.999-99");
  $("#cep").mask("99999-999");
  $("#phone").mask("(99) 9999-9999");
  $(".phone").mask("(99) 9999-9999");
  $("#tin").mask("99-9999999");
  $("#ssn").mask("999-99-9999");
  $("#product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
  $("#eyescript").mask("~9.99 ~9.99 999");
  $('.valor').priceFormat({
              prefix: '',
              centsSeparator: ',',
              thousandsSeparator: ''
        });
});
  </script>
  </head>
  <body>
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
          if($_GET["centro"]=="estoque_ini")
            include("estoque/inicial.php");
          else
            include("$_GET[centro]/index.php");
            
      echo "</div>";
    }
    
    ?>
  </div>
  </body>
</html>
