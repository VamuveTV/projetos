<?php
include("lib.php");
$acao  = $_POST["acao"];
if($acao=="Enviar")
{
  if($nome && $email && $curso && $telefone && $como_soube)
  {
    //buscando se o aluno j� � cadastrado pelo e-mail
    $sql = "SELECT codigo FROM alunos WHERE email='$email'";
    $res = mysql_query($sql);
    if(mysql_num_rows($res)>0)//aluno j� cadastrado
      list($codaluno)=mysql_fetch_row($res);
    else{//aluno n�o cadastrado
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
      $headers .= 'From: Matr�culas <matriculas@zarbsolution.com.br>' . "\r\n";

      //buscando o nome do curso
      $sql2 = "SELECT nome FROM cursos WHERE codigo='$dados[0]'";
      $res2 = mysql_query($sql2);
      list($nome_curso)=mysql_fetch_row($res2);
      $log = "<p>Inscri&ccedil;&atilde;o realizada. Efetue seu pagamento!</p>";
      mail("fernando@zarbsolution.com.br","Nova matr�cula $cod_matricula | $nome_curso", "O aluno $nome se matriculou no curso $nome_curso", $headers);
      mail("dayana@zarbsolution.com.br","Nova matr�cula $cod_matricula | $nome_curso", "O aluno $nome se matriculou no curso $nome_curso", $headers);
      $pagamento = 1;
    }
    else
      $log = "<p>Falha ao enviar dados. Tente mais tarde</p>";
  }
  else
    $log = "Preencha todos os campos.";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" type="text/css" href="rotator.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.superbox.css" media="all" />
  <title>Zarb Solution - Solu&ccedil;&otilde;es em TI</title>
  <script type="text/javascript" src="js/jquery-1.4.4.js"></script>
  <script type="text/javascript" src="js/jquery.shadow.js"></script>
  <script type="text/javascript" src="js/jquery.superbox-min.js"></script>
  <script type="text/javascript">
  function mostraConteudo(item){
    item = '#'+item;
    $('.detalhes:not('+item+')').hide();
    $(item).slideToggle();
  }
  </script>
  </head>
  <body>
  <div id="tudo">
    <div id="topo">
      <img src="img/logo.png" id="logo" />
    </div>
    <div id="menu">
      <div id="conteudo_menu">
				<a href="index.php" class="comum">Home</a>
				<a href="cursos.php" class="comum">Cursos</a>
				<a href="servicos.php" class="comum">Servi&ccedil;os</a>
				<a href="produtos.php" class="comum">Produtos</a>
				<a href="portfolio.php" class="comum">Portfolio</a>
                <a href="noticias.php" class="comum">Not&iacute;cias</a>
        <a href="trabalhe.php" class="comum">Trabalhe Conosco</a>
				<a href="contato.php">Contato</a>
	  </div>
    </div>
    <div id="meio" style="min-height: 600px">
    	 <div id="curs">
       <h1 class="titulo_azul_clar">Cursos</h1>
        <?php
        if(!isset($pagamento))
        {
        ?>
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
            <td><b>Observa��o ou coment�rio:</b></td>
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
        </form>
        <?php
        }
        else{
        ?>
        <form action="inscricao.php" method="post">
        <table class="tbl" cellpadding="3" cellspacing="1" align="center">
          <tr class="tbl_body">
            <td><b>Curso:</b></td>
            <td>
            <?php echo $nome_curso; ?>
            </td>
          </tr>
          <tr class="tbl_body">
            <td><b>Nome completo:</b> </td>
            <td><?php echo $nome;?></td>
          </tr>
          <tr class="tbl_body">
            <td><b>Email:</b></td>
            <td><?php echo $email;?></td>
          </tr>
          <tr class="tbl_body">
            <td><b>Telefone:</b></td>
            <td><?php echo $telefone;?></td>
          </tr>
          <tr class="tbl_body">
            <td colspan="2">
              <input type="image" src="img/ico_pagamento.gif" alt="Efetuar pagamento" />
            </td>
          </tr>
        </table>
        <center><?=$log;?></center>
        </form>
        
        <?php
        }
        ?>
       </div>
       <div id="curs2">
            <a href="contato.php"><img src='img/ico_duvidas.png' alt="D�vidas" style="border: 1px #000 solid;" /></a>
            <img src="img/pagseguro.gif" />
       </div>
        <br style="clear: both" />
    </div>
  </div>
  <div class='limpa'></div>
  <div id="rodape">
    <div id="conteudo_rodape">
      <div id="rodape1">
        <img src="img/logo_transp2.png" alt="Zarb Solution" />
        <p>
        Zarb Solution Ltda. - Solu&ccedil;&otilde;es em TI<br />
        <b>Telefone: 31 3309-1900</b> <br />
        E-mail: contato@zarbsolution.com.br <br />
        </p>
      </div>
      <div id="rodape2">
        <h2>Navega��o</h2>
        <a href="index.php">Home</a><br />
        <a href="cursos.php">Cursos</a><br />
        <a href="servicos.php">Servi�os</a><br />
        <a href="produtos.php">Produtos</a><br />
        <a href="portfolio.php">Portfolio</a><br />
        <a href="trabalhe.php">Trabalhe Conosco</a><br />
        <a href="contato.php">Contato</a>
      </div>
      <div id="rodape3">
        <h2>Produtos</h2>                                     
        <a href="produtos.php?prod=zarbfood">ZarbFood</a><br />
        <a href="produtos.php?prod=zarbhotel">ZarbHotel</a><br />
        <a href="produtos.php?prod=zarbtur">ZarbTur</a><br />
        <a href="produtos.php?prod=zarbponto">ZarbPonto</a><br />
      </div>
      <div class="limpa"></div>
    </div>
  </div>
  </body>
</html>
