<?
  ##---------------------------------------------------
  ##  Conexão ao banco de dados MySQL usando PHP
  ##---------------------------------------------------
  # Mais detalhes sobre o PHP e MySQL:
  #   http://br.php.net/mysql
  #
  # Mais detalhes sobre MySQL:
  #   http://www.mysql.com/
  ##---------------------------------------------------

  ## OBSERVAÇÃO: Não esqueça de colocar a senha para conexão.

  # Definindo as variaveis
  $servidor = 'localhost';
  $usuario = 'root';
  $key = 'vertrigo';
  $banco = 'zarb';
  
  /*
  $servidor = 'localhost';
  $usuario = 'zarbsolu_zarb';
  $key = 'samh678';
  $banco = 'zarbsolu_zarb';
  */
  # Conectando, escolhendo o banco de dados
   $link = mysql_connect($servidor, $usuario, $key)
       or die('Não foi possivel conectar: ' . mysql_error());

//   print 'Conexão bem sucedida';

   mysql_select_db($banco) or die('Não pude selecionar o banco de dados');
   
?>                
