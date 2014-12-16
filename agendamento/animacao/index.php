<?php
header("Content-type: text/html; charset=utf-8");
include('bd.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript">
  function sub(categoria){
    var subbox = '#subbox'+categoria; 
    var p = $('#esquerda');
    var p1 = $(subbox);
    var position = p.position();
    var position1 = p1.position();
    e = -position1.left - 258;      
    t = -position1.top + 126;
    
    conteudo = $(subbox).html();
    
    $(subbox).animate({'top': t},
      function(){
        $(this).animate({'left': e },
            function(){
              $('#nivel2').append('<span id="loader">Carregando...</span>');
              
              $(subbox).hide();
              $('.box').hide();
              $('#esquerda').append('<div class="box" style="top: 126px">'+conteudo+'</div>');
              //carregando o nivel 3
              //$('#nivel2').append('<h2>testando</h2>');
              $.post('nivel3.php',{categoria: categoria},
                function(dados){
                  $('#loader').hide();
                  $('#nivel2').append(dados);
                }
              )        
            }
        );
      }
    )
  }
  
  function nivel2(categoria){
    
    var box = '#box'+categoria;
    $('#esquerda').show();
    $('.maior:not('+box+')').hide();
    $(box).css({'width':'240px'});
    
    var p1 = $(box);    
    var position1 = p1.position();
    e = -250;
    $(box).animate({'left':e},
                    function(){
                      $('#esquerda').after('<div id="nivel2"></div>');
                      posnivel2 = $('#nivel2').position().left;
                      $('#nivel2').css('left',posnivel2+260);
                      
                      $.post('nivel2.php',{categoria:categoria},
                      function(dados){            
                        $('#nivel2').html(dados);
                      })
                    }
                  );
  }
  
  </script>
  <style type="text/css">
  #painel{
    /* border: 1px black solid; */
    width: 1000px;
    height: 600px;
    font-family: arial;
    font-size: 11px;
    margin: 0 auto;
    font-family: "PT Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  }
  
  #esquerda{
    /* border: 1px blue solid; */
    margin: 0;
    width: 250px;
    float: left;
    height: 600px; 
    display: none;     
  }
  #direita{
    /* border: 1px red solid; */
    margin: 0;
    width: 745px;
    float: left;
    height: 600px;    
  }
  #nivel2{
    position:absolute;  
    width: 745px;
    height: 600px;
  }
  .box{
    position: relative;
    width: 240px;
    height: 120px;
    background: #ddd;
    margin: 3px;
    float: left;
    cursor: hand;
  }
  .maior{
    text-align: center;
    position: relative;
    width: 325px;
    height: 120px;
    background: #ddd;
    margin: 3px;
    float: left;
    cursor: hand;
  }
  .produto{
    text-align: center;
    position: relative;
    width: 240px;
    height: 260px;
    background: #eee;
    margin: 3px;
    float: left;
    cursor: hand;
  }
  .botao{
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    -webkit-border-radius: 3px;
       -moz-border-radius: 3px;
            border-radius: 3px;
    border-width: 1px;
    border-color: #444645;
    background-color: #444645;
    background-image: none;
    color: #e8e8e8;
    padding: 10px;
    text-decoration: none;
  }
  .botao:hover{
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    -webkit-border-radius: 3px;
       -moz-border-radius: 3px;
            border-radius: 3px;
    border-width: 1px;
    border-color: #ed3237;
    background-color: ##ed3237;
    background-image: none;
    color: #e8e8e8;
    padding: 10px;
    text-decoration: none;
  }  
  .box:hover{
    background: rgb(0,204,204);  
  }
  .boxprincipal{
    background: orange;
  }
  .boxprincipal:hover{
    background: rgb(255,102,0);
  }
  .box p{
    text-align: center;
  }
  </style>
  </head>
  <body>
  <div id="painel">
      <div id="esquerda">       
      </div>
        <?php
        $sql = "SELECT id, nome, icone FROM categoria WHERE tipo='C' ORDER BY id";
        $result = mysql_query($sql);
        while(list($id,$nome,$icone)=mysql_fetch_row($result))
        {
            echo "<div id=\"box$id\" class=\"maior\" onclick=\"nivel2('$id')\">
                    <p>
                    <img src='$icone' width='64'><br>
                    $nome
                    </p>
                  </div>";
        }
        ?>              
    </div>

  </body>
</html>
