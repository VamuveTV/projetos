<?php
session_start();


mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");

/*
mysql_connect("localhost","root","");

mysql_select_db("agendamento");
*/

if(isset($_POST['acao'])){
  $sql = "SELECT nome, endereco, email FROM tbl_pontos WHERE id='".$_POST['ponto']."'";
  $result = mysql_query($sql);
  list($nome,$endereco,$email_ponto)=mysql_fetch_row($result);
  $conteudo = '<div style="font-family: arial; font-size: 14px; border: 1px black solid; padding: 5px;">
               <h3>Confirmação de agendamento</h3>
               <p>Nome: '.$_POST['nome'].'</p>
               <p>E-mail: '.$_POST['email'].'</p>
               <p>Número do pedido: '.$_POST['numero'].'</p>
               <p>Dia: '.$_POST['data'].'</p>
               <p>Hora: '.$_POST['hora'].'</p>
               <p>Local: '.$nome.'<br>'.$endereco.'</p>
               </div>';
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
  $headers .= 'From: AC Digital <agendamento@acdigital.com.br>' . "\r\n";            
            
  if(mail($_POST['email'], 'Confirmação de agendamento', $conteudo, $headers)){
    mail('agendamento@acdigital.com.br', 'Confirmação de agendamento', $conteudo, $headers);
    mail($email_ponto, 'Confirmação de agendamento', $conteudo, $headers);
    $msg = "Agendamento realizado com sucesso";
  }else
    $msg = "Falha ao registrar agendamento. Entre em contato por telefone";            
  
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #tudo{
      width: 750px;
      margin: 40px auto;
      border: 1px #000 solid;
      padding: 10px;
      background-image: url('logo.png');
      background-repeat: no-repeat;
      background-position: right bottom;
    }
    .form-group{
      width:400px; 
    }
    </style>    
  </head>
  <body>
  <div id="tudo">
    <h2>Agendamento</h2>
    <form role="form" method="post">
    <div class="form-group">
      <label for="numero">Número do pedido</label>
      <input type="text" required name="numero" class="form-control">
    </div>
    
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" required name="nome" class="form-control">
    </div>
    
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" required name="email" class="form-control">
    </div>    
      
    <div class="form-group">
      <label for="estado">Estado</label>
      <select class="form-control" id="estado" required name="estado">
      <option></option>
      <?php
      $sql = "SELECT uf, nome FROM tb_estados ORDER BY uf";
      $result = mysql_query($sql);
      while(list($uf,$nome)=mysql_fetch_row($result)){
        echo "<option value='$uf'>$nome</option>";
      }
      ?>
      </select>
    </div>
    <div class="form-group">
      <label for="cidade">Cidade</label>
      <span id="combo_cidade">
      <select class="form-control" required id="cidade" name="cidade">
      
      </select>
      </span>
    </div>
    
    <div class="row">
      <div class="col-md-1" style="width: 200px"><label>Data</label>
        <div class='input-group date' id='datetimepicker1'>
                    <input type='text' required data-date-format="DD/MM/YYYY" name="data" class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
        
      </div>
      <div class="col-md-1" style="width: 200px"><label>Hora</label>
        <div class='input-group date' id='datetimepicker4'>
                    <input type='text' required data-date-format="HH:mm" name="hora" class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
    </div>
    </div>
    
    <div id="pontos" style="margin: 6px"> 
    </div>
    
    <hr>
    <button type="submit" name="acao" class="btn btn-primary">Agendar</button>
    <br>
    <?php
    if(isset($msg))
      echo "<p><b>$msg</b></p>";
    ?>
  </form>
  
  
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/bootstrap-datetimepicker.pt-BR.js"></script>
    <script>
    $(document).ready(function(){
      $('#datetimepicker1').datetimepicker({
                    language: 'pt-BR'
                });      
                
      $('#datetimepicker4').datetimepicker({
                    pickDate: false
                });
      $('#estado').change(function(){
        uf = $(this).val();
        
        $.post('busca_cidade2.php',{uf: uf},
          function(dados){
            
            $('#combo_cidade').html(dados);
          }
        )
      })
      
      
    })
    function busca_pontos(cidade){        
        $.post('busca_pontos.php',{cidade: cidade},
          function(dados){
            
            $('#pontos').html(dados);
          }
        )
      }
    </script>
    
  
  </body>
</html>