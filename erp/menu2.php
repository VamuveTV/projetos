<?php
include("conectar.php");
$sql = "SELECT * FROM transferencia WHERE destino='".$_SESSION['unidade_usu']."' AND autorizado IS NULL";
$res = mysql_query($sql);
$n = mysql_num_rows($res);
if($n > 0)
	$comp = '<span class="badge badge-important">'.$n.'</span>';
else
	$comp = '';
?>
<ul class="nav nav-pills">
    <?php
    if ($_SESSION['perfil'] == 1)
    {
    ?>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="../#">
        Cadastros
        <b class="caret"></b>
      </a>			
	<ul class="dropdown-menu">
	  <!-- links -->
		<!-- <li><a href="empresas/">Empresas</a></li> -->
		<li><a href="clientes/">Clientes</a></li>
		<li><a href="fornecedores/">Fornecedores</a></li>
		<li><a href="marcas/">Marcas</a></li>
		<li><a href="produtos/">Produtos</a></li>
		<li><a href="fotos/">Fotos de Produtos</a></li>
		<!-- <li><a href="produtos_config/">Produtos Configuráveis</a></li> -->
		<li><a href="classificacao/">Classificação</a></li>
		<li><a href="unidades/">Unidades</a></li>
		<li><a href="usuarios/">Usuários</a></li>
		<li><a href="promocoes/">Promoções</a></li>
	</ul>
	</li>
    <?php }

    if (($_SESSION['perfil'] == 1) or ($_SESSION['perfil'] == 3))
    {
    ?>
	<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="../#">
        Almoxarifado <?php echo $comp;?>
        <b class="caret"></b>
      </a>			
	<ul class="dropdown-menu">
	  <!-- links -->
	  	
		<li><a href="estoque/">Estoque</a></li>
		<li><a href="transferencia/">Transferência de Estoque <?php echo $comp;?></a> </li>
	</ul>
	</li>
    <?php
    }
    if (($_SESSION['perfil'] == 1) or ($_SESSION['perfil'] == 2))
    {
    ?>
	<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="../#">
        Financeiro
        <b class="caret"></b>
      </a>			
	<ul class="dropdown-menu">
	  <!-- links -->
		<li><a href="vendas/">Vendas</a></li>
		<li><a href="receber_vendas/">Receber pagamentos</a></li>		
	</ul>
	</li>
    <?php }
    if ($_SESSION['perfil'] == 1)
    {
    ?>
	<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="../#">
        Configurações
        <b class="caret"></b>
      </a>			
	<ul class="dropdown-menu">
	  <!-- links -->
		<li><a href="config_crediario/">Crediário</a></li>
	</ul>
	</li>
    <?php } ?>
</ul>