<?
define("CODADMIN","1");//código da Zarb Solution na tabela clientes
?>
<ul>
  <li class="titulo">Servi&ccedil;os</li>
    <li><a href="principal.php?centro=newsletter" class="opmenu">Newsletter</a></li>
    <li><a href="principal.php?centro=news" class="opmenu">Cadastros Newsletter</a></li>
    <?
    if($_SESSION[cliente_usu] == CODADMIN) //Se for alguem da zarb exibe select para edição do status, senao apenas exibe o status
      echo "<li><a href=\"principal.php?centro=sistemas\" class=\"opmenu\">Sistemas</a></li>
            <li><a href=\"principal.php?centro=cliente_sistema\" class\"opmenu\">Sistemas de Cliente</a></li> ";
    
      echo "<li><a href=\"principal.php?centro=meusdados\" class=\"opmenu\">Meus dados</a></li>";
    ?>
    <li><a href="principal.php?centro=chamados" class="opmenu">Chamados</a></li>

    <li style="border-bottom: 0px"><a href="logout.php" class="opmenu"><b>Sair</b></a></li>
</ul>
