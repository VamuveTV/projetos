<?php
include("lib.php");
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
$(document).ready(function() {  
  $('#curs tbody tr:even').addClass('par');
  $('#curs tbody tr:odd').addClass('impar');
  $('#curs tbody tr').hover(function(){
    $(this).addClass('destaque');
  },
  function(){
    $(this).removeClass('destaque');
  }
  )
});//Close Function
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
    <div id="meio" style="min-height: 900px">
    	<h1 class="titulo_azul_clar">Cursos</h1>
    	<p><span style='color:#444'>A </span><b style="color: #339999">Zarb Solution</b><span style='color:#444'> &eacute; especializada em capacita&ccedil;&atilde;o
        e foca seus treinamentos na forma&ccedil;&atilde;o de profissionais de TI, al&eacute;m de oferecer diversos cursos desde Inform&aacute;tica b&aacute;sica
        at&eacute; poderosas ferramentas como AutoCad entre outras.
    	Possu&iacute;mos laborat&oacute;rios pr&oacute;prios e uma excelente estrutura para atender nossos alunos.</span></p>
    	<p><span style='color:#444'>Oferecemos tamb&eacute;m <b style="color: #339999">"Treinamento In Company"</b> para empresas que queiram capacitar sua equipe.</span></p>
    	<p><span style='color:#444'>Todos os professores s&atilde;o altamente qualificados com experi&ecirc;ncia comprovada no mercado de trabalho.</span></p>
    	<h2 style="color: #339999;font-size:14px;">Turmas abertas: <small>(clique para ver o conte&uacute;do program&aacute;tico)</small></h2>
        <div id="curs">
        <table width="100%" cellpadding="2px" border="1px">
          <thead>
          <tr class="tbltit">
            <td>Curso</td>
            <td>Calend&aacute;rio</td>
            <td>Hor&aacute;rio</td>
            <td>Carga Hor&aacute;ria</td>
          </tr>
          </thead>
          <tbody>
      <?php
       $sql = "SELECT t.codigo, c.nome, c.descricao, t.periodo, t.turno, t.titulo, t.carga, t.pagamento, t.observacao, t.status ";
       $sql.= "FROM cursos AS c, turmas AS t WHERE t.curso = c.codigo AND status = 'N' ORDER BY c.nome";
       $res = mysql_query($sql);
         while(list($codturma,$nomecurso,$descricao,$periodo,$turno,$titulo,$carga,$pagamento,$observacao,$status)=mysql_fetch_row($res)){

         echo "<tr>
                 <td><a href='#' onclick=\"window.open('detalhescurso.php?codturma=$codturma','Detalhes','scrollbars=yes,height=900,width=650')\">$nomecurso</a></td>
                 <td><a href='#' onclick=\"window.open('detalhescurso.php?codturma=$codturma','Detalhes','scrollbars=yes,height=900,width=650')\">$periodo</a></td>
                 <td><a href='#' onclick=\"window.open('detalhescurso.php?codturma=$codturma','Detalhes','scrollbars=yes,height=900,width=650')\">$turno</a></td>
                 <td><a href='#' onclick=\"window.open('detalhescurso.php?codturma=$codturma','Detalhes','scrollbars=yes,height=900,width=650')\">$carga</a></td>
         </tr>";

       }
       ?>
        </tbody>
       </table>
       </div>
       <br><br>
       <fieldset style="width:97%"><legend style="color: #000066;font-weight:bold;font-size:12px;">Fa&ccedil;a sua pr&eacute;-inscri&ccedil;&atilde;o</legend>
        <form action="cursos.php" method="post">
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
        <center><span style='color:red'><?=$log;?></span></center>
        <br />
        <p>Contatos para dúvidas:</p>
        <b>Telefone:</b> 31 3789-3201<br />
        <b>E-mail:</b> contato@zarbsolution.com.br
        </form>
       </fieldset>
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
        <h2>Navegação</h2>
        <a href="index.php">Home</a><br />
        <a href="cursos.php">Cursos</a><br />
        <a href="servicos.php">Serviços</a><br />
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
