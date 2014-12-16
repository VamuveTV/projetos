<?php

mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");

/*
mysql_connect("localhost","root","");

mysql_select_db("agendamento");
*/

$cidade = $_POST['cidade'];

$sql = "SELECT id, nome, endereco, telefones, email, dias, hora_inicio, hora_fim FROM tbl_pontos WHERE cidade='$cidade' ORDER BY nome";
$result = mysql_query($sql);
echo '<table class="table table-striped table-bordered" style="width: 550px">';
if(mysql_num_rows($result)>0)
{
  $ct = 0;
  while(list($id,$nome,$endereco,$telefones,$email,$dias,$hora_inicio,$hora_fim)=mysql_fetch_row($result)){
    $ct++;
    if($ct==1)
      $comp = ' checked';
    else
      $comp = '';
    echo "<tr>
            <td valign='middle'><input type='radio' name='ponto' value='$id'></td>
            <td>
              <b>$nome</b>
              <p><b>Endereço:</b> $endereco<br>
              <b>E-mail:</b> $email Telefone: $telefones<br>
              <b>Dias de atendimento:</b> ";
              $vdias = explode('#',$dias);
              foreach($vdias as $d)
                echo "$d ";
              echo "<br>
                    <b>Horário de atendimento:</b> $hora_inicio a $hora_fim</p>
          </tr>";
  }
}
else
{
  echo "<tr><td>Nenhum ponto de atendimento nesta localidade</td></tr>";
} 

echo '</table>';
?>