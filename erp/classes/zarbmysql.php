<?php

class ZarbMysql
{
  public $mensagem;
  
  public function insere($tabela, $campos, $dados) {

    $sql = "INSERT INTO $tabela(";
    $ct=0;
    foreach($campos AS $val){
      $sql.= "$val";
      $ct++;
      if($ct < count($campos))
        $sql.= ", ";
    }
    $sql.= ") VALUES (";
    $ct = 0;
    foreach($dados AS $val){
      $sql.= "'$val'";
      $ct++;
      if($ct < count($dados))
        $sql.= ", ";
    }
    $sql.= ")";
    $res = mysql_query($sql);
    if($res){
      $this->mensagem = "Dados cadastrados com sucesso.";
    }
    else
      $this->mensagem = "Falha ".mysql_error();
     
    return $this->mensagem;
  }
  
  public function atualiza($tabela, $campos, $dados, $codigo) {

    $sql = "UPDATE $tabela SET ";
    $ct=0;
    foreach($campos AS $i => $val){
      $sql.= "$val='".$dados[$i]."'";
      $ct++;
      if($ct < count($campos))
        $sql.= ", ";
    }
    $sql.= " WHERE codigo='$codigo' ";
    $res = mysql_query($sql);           
    if($res){
      $this->mensagem = "Dados modificados com sucesso.";
    }
    else
      $this->mensagem = "Falha: $sql ".mysql_error();
           
    return $this->mensagem;
  
  }
  
  public function deleta($tabela, $registro) {
    
    $sql = "DELETE FROM $tabela WHERE codigo='$registro'";
    $res = mysql_query($sql);
    if($res){
      $this->mensagem = "Dados exclu&iacute;dos com sucesso.";
    }
    else
      $this->mensagem = "Falha: ".mysql_error();
    
    return $this->mensagem;
  
  } 
}

?>
