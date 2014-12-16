<?
include("../../bd.php");

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,6,4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  <style type="text/css">
  body{
    font-family: verdana;
  }
  
  .relatorio{
    background: #000000;
    width: 450px;
  }
  
  td, th{
    background: #FFFFFF;
    font-family: verdana;
    font-size: 10px;
  }
  h1{
    font-size: 18px;
  }
  .subtitulo{
      background: #339999;
      color: #FFFFFF;
      font-weight: bold;
  }
  .subtitulo2{
      background: #EEEEEE;
  }
  </style>
  </head>
  <body>
    <?
    extract($_GET);
    
    if($data_ini)
      $data_ini = converte_data($data_ini,"banco");
    
    if($data_fim)
        $data_fim = converte_data($data_fim,"banco");
    
    echo "<table cellpadding=\"3\" cellspacing=\"1\" align=\"center\" style='width:740px' class='relatorio' border='0'>";
      echo "<tr><td colspan='7'>
        <table align='center' class='relatorio' style='background: #FFF;width:740px;' border='0' cellspacing='1'>
        <td align='center' style='background:#FFF;border-right: 1px #000 solid'><img src='logo_transp.png' /></td><td style='background:#FFF' align='center' nowrap><h1>Relat&oacute;rio de Livro Caixa</h1>";
        if($data_ini && $data_fim)
        {
          echo "<br /><h5><b>Movimenta&ccedil;&otilde;es de ".converte_data($data_ini,"usuario")." a ".converte_data($data_fim,"usuario")."</h5><br />";
        }
        echo $msg_erro;
        echo "</td>
      </table>
      </td></tr>";
      $sql2 = "SELECT codigo, data, descricao, tipo, valor FROM livrocaixa ";
      $sql2.= "WHERE codigo<>'0' ";
      if($data_ini)
      {
        $sql2.= "AND data >= '$data_ini'";
      }
      if($data_fim)
      {
        $sql2.= "AND data <= '$data_fim'";
      }
      if($tipo){
        $sql2.= "AND tipo='$tipo' ";
      }
      $sql2 .= "ORDER BY data ";
      $res2 = mysql_query($sql2);
      if(mysql_num_rows($res2)==0)
        echo "<tr><td bgcolor='#EEE' colspan='7'><b>Nenhuma movimenta&ccedil;&atilde;o encontrada</b></td></tr>";
      else
        {
        echo "
            <tr>
              <td class=\"subtitulo\" nowrap>Data</td>           
              <td class=\"subtitulo\" nowrap>Descri&ccedil;&atilde;o</td>
              <td class=\"subtitulo\" nowrap>D&eacute;bito</td>
              <td class=\"subtitulo\" nowrap>Cr&eacute;dito</td>
              <td class=\"subtitulo\" nowrap>Saldo</td>
            </tr>";
        
        
        while(list($codigo, $dt, $descricao, $tipo, $valor)=mysql_fetch_row($res2))
        {
          $dt = converte_data($dt,"usuario");
          switch($tipo){
            case 'E': $tipo = "Entrada";$t_valor += $valor;break;
            case 'S': $tipo = "Sa&iacute;da";$t_valor -= $valor;
          }
          echo "<tr>
            <td>$dt</td>
            <td nowrap>$descricao</td>";
            if($tipo=='Sa&iacute;da')
              echo "<td nowrap><font color='red'>R$ ".number_format($valor,2,",",".")."</font></td>";
            else
              echo "<td></td>";
            if($tipo=='Entrada')
              echo "<td nowrap>R$ ".number_format($valor,2,",",".")."</td>";
            else
              echo "<td></td>";
            
            echo "<td align='right' nowrap> R$ ".number_format($t_valor,2)."</td>";
        }
            echo "<tr><td colspan='4' align='right' nowrap><b>Total</b></td><td align='right' nowrap><b>R$ ".number_format($t_valor,2)."</b></td></tr>";
      }
    ?>
  </table><br />
  <center><input type="button" value="Imprimir" onclick="window.print()" /></center>
  </body>
</html>
