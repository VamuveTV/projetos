<?php
session_start();

unset($_SESSION[cod_usu]);
unset($_SESSION[nome_usu]);
unset($_SESSION[cliente_usu]);
unset($_SESSION[email_usu]);

echo "<script>document.location='../index.php'</script>";
?>
