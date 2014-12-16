var	ajaxloader	=	'carregando';
var	errorloader =	'erro';


function vSenha2(){
    senha = senha_atual.value;
    codigo_usuario = codigo.value;

    $.post("ajax_validaSenha.php",{senha: senha, codigo_usuario: codigo_usuario}, function(retorno){
        if(retorno == '2'){
            senha_atual.setCustomValidity('Senha atual inválida!')
        }
        else
        {
            senha_atual.setCustomValidity('')
        }
    })
}

function vSenha(){
    var senha1	=	document.getElementById('novasenha');
    var senha2	=	document.getElementById('senha2');

    if(senha1.value != senha2.value)
        senha2.setCustomValidity('Senhas não conferem!')
    else
        senha2.setCustomValidity('')
}

function chamaTabela() {
	$.ajax({//método ajax
		url: "edita.php", //página requisitada
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
		}
	}); 
}

function janelaConfirma (codigo) {
    $("#myModal").modal ("show");
    $("#myModal #valor").val(codigo);
}

function confirma () {	
    var codigo =  $("#myModal #valor").val();    	
    $("#myModal").modal ('hide');
    excluir(codigo);
};

		$(document).ready(function(){
			
			//var	ajaxloader	=	'<img src="images/ajax-loader.gif" height="16px" width="16px">';
			//var	errorloader =	'<img src="images/erro.gif" height="16px" width="16px">'; 
				

			chamaTabela();
			/* Função para atualizar a tabela ou chamar ela.*/
			/*  Salvar */
			$('#salvar').live ({
				click: function(){
                    alert('teste');
					var cod	=	$('#codigo').val();
					var novasenha =	$('#novasenha').val();

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, novasenha : novasenha},
                            success: function(retorno){ //em caso de sucesso
                                fecha();
                                $('.log').html('<div class="alert alert-info">'+retorno+'</div>');
                                chamaTabela();
                            },
                            error: (function() {
                                $(".log").html('<div class="alert alert-error">Falha ao editar</div>'); // seta a frase de erro, caso falhe.
                            })
                        });
                    }else console.log("invalid form");
                }
			}); /* fim Salvar */
			
			/* Cancelar */
			$('#cancelar').live ({
				click: function(){
					fecha();			
				}
			}); /*fim Cancelar*/


			
		}); /* fim do document ready*/