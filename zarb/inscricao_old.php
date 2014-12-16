<head>
  <link rel="stylesheet" type="text/css" href="style2.css" /> 
</head>
<?php
include("bd.php");
$acao  = $_POST["acao"];
if($acao=="Enviar")
{
  if($nome && $email && $curso && $telefone && $como_soube)
  {
    //buscando se o aluno já é cadastrado pelo e-mail
    $sql = "SELECT codigo FROM alunos WHERE email='$email'";
    $res = mysql_query($sql);
    if(mysql_num_rows($res)>0)//aluno já cadastrado
      list($codaluno)=mysql_fetch_row($res);
    else{//aluno não cadastrado
      //cadastrando o aluno
      $sql = "INSERT INTO alunos(nome, email, telefone, como_soube) VALUES ('$nome','$email','$telefone', '$como_soube')";
      $res = mysql_query($sql);
      $codaluno = mysql_insert_id();
    }

    //cadastrando a matricula
    $hoje = date("Y-m-d");
    $dados = explode('_', $_POST['curso']);
    $sql = "INSERT INTO matriculas(curso,turma,aluno,data,observacao)VALUES('$dados[0]','$dados[1]','$codaluno','$hoje','$msg')";
    $res = mysql_query($sql);
    if($res){
      $cod_matricula = mysql_insert_id();
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'From: Matrículas <matriculas@zarbsolution.com.br>' . "\r\n";

      //buscando o nome do curso
      $sql2 = "SELECT nome FROM cursos WHERE codigo='$dados[0]'";
      $res2 = mysql_query($sql2);
      list($nome_curso)=mysql_fetch_row($res2);
      $log = "<p>Seus dados foram enviados com sucesso. Aguarde nosso contato</p>";
      mail("fernando@zarbsolution.com.br","Nova matrícula $cod_matricula | $nome_curso", "O aluno $nome se matriculou no curso $nome_curso", $headers);
      mail("dayana@zarbsolution.com.br","Nova matrícula $cod_matricula | $nome_curso", "O aluno $nome se matriculou no curso $nome_curso", $headers);
    
    }
    else
      $log = "<p>Falha ao enviar dados. Tente mais tarde</p>";
  }
  else
    $log = "Preencha todos os campos.";
}
?>
<h1>Faça sua inscrição</h1>
<form action="inscricao.php" method="post">
<table class="tbl" cellpadding="3" cellspacing="1" align="center">
  <tr class="tbl_body">
    <td><b>Curso:</b></td>
    <td>
    <select name="curso" class="campo">
      <option value=''>Selecione</option>
      <?php
      $sql = "SELECT c.codigo, c.nome, t.codigo, t.turno FROM cursos AS c, turmas AS t WHERE t.curso=c.codigo AND status = 'N' ORDER BY c.nome";
      $res = mysql_query($sql);
      while(list($codcurso,$nomecurso,$codturma,$turno)=mysql_fetch_row($res)){
        $v = $codcurso.'_'.$codturma;
        echo "<option value='$v'>$nomecurso - $turno</a>";
      }
      ?>
    </select>
    </td>
  </tr>
  <tr class="tbl_body">
    <td><b>Nome completo:</b> </td>
    <td><input type="text" name="nome" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Email:</b></td>
    <td><input type="text" name="email" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Telefone:</b></td>
    <td><input type="text" name="telefone" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Observação ou comentário:</b></td>
    <td>
      <textarea name="msg" class="campo" rows="6" cols="40"></textarea>
    </td>
  </tr>

  <tr class="tbl_body">
    <td><b>Como soube do curso?</b></td>
    <td>
      <textarea name="como_soube" class="campo" rows="2" cols="40"></textarea>
    </td>
  </tr>

  <tr class="tbl_body">
    <td colspan="2">
      <input type="submit" name="acao" value="Enviar" class="botao" />
      <input type="reset" name="acao" value="Limpar" class="botao" />
    </td>
  </tr>
</table>
<center><?=$log;?></center>
<br />
<p>Contatos para dúvidas:</p>
<p><b>Telefone:</b> 31 3789-3201<br /></p>
<p><b>E-mail:</b> contato@zarbsolution.com.br</p>
</form>