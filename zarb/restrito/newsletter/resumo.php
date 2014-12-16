<?
include("../../bd.php");

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
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
  
  table{
    background: #000000;
    width: 450px;
  }
  
  td{
    background: #FFFFFF;
    font-family: verdana;
    font-size: 10px;
  }
  h1{
    font-size: 20px;
  }
  .subtitulo{
      background: #EEEEEE;
  }
  </style>
  </head>
  <body>
  <h1>Resumo de Envio</h1>
    <?
    extract($_GET);
    
    $query = "SELECT r.codigo, r.data, r.quantidade, r.inicio, r.fim, p.nome ";
    $query.= "FROM resumo AS r, pecas AS p WHERE p.codigo=r.peca ";
    if($inicio){
      $inicio = converte_data($inicio,"banco");
      $query.= "AND r.data >= '$inicio' ";
    }
    if($fim){
      $fim = converte_data($fim,"banco");
      $query.= "AND r.data <= '$fim' ";
    }
    $query.= "ORDER BY p.nome, r.data ";
    $res = mysql_query($query);

    echo "<table cellpadding=\"3\" cellspacing=\"1\">
    <tr>
      <td class=\"subtitulo\" nowrap>Peça</td>
      <td class=\"subtitulo\" nowrap>Data do envio</td>
      <td class=\"subtitulo\" nowrap>Cadastrados a partir de</td>
      <td class=\"subtitulo\" nowrap>Cadastrados até</td>
      <td class=\"subtitulo\" nowrap>Quantidade</td>
    </tr>";
    
    while(list($codigo, $data, $quantidade, $inicio, $fim, $peca)=mysql_fetch_row($res))
    {
      $data = converte_data($data,"usuario");
      $inicio = $inicio=="0000-00-00"?"-":converte_data($inicio,"usuario");
      $fim = $fim=="0000-00-00"?"-":converte_data($fim,"usuario");
      echo "<tr>
            <td nowrap>$peca</td>
            <td align='center' nowrap>$data</td>
            <td align='center' nowrap>$inicio</td>
            <td align='center' nowrap>$fim</td>
            <td align='center' nowrap>$quantidade</td>
          </tr>";
    }
    ?>
  </table><br />
  <input type="button" value="Imprimir" onclick="window.print()" />
  </body>
</html>
