<?php

/*
$dbh=mysql_connect ("localhost", "upgrade_erp", "erpupgrade")
      or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("upgrade_erp")
      or die ('I cannot select to the database because: ' . mysql_error());
 */


$dbh=mysql_connect ("localhost", "root", "")
    or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("erp")
    or die ('I cannot select to the database because: ' . mysql_error());


/*
$dbh=mysql_connect ("localhost", "kservido_sirlan", "123mudar")
    or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("kservido_erp")
    or die ('I cannot select to the database because: ' . mysql_error());
*/
?>