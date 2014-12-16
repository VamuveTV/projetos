var	ajaxloader	=	'carregando';
var	errorloader =	'erro';		


function vLogin(campologin){
    login = campologin.value;
    $.post("ajax_validaLogin.php",{login: login}, function(retorno){
        if(retorno == '2'){
            campologin.setCustomValidity('Login já existe!')
        }
        else
        {
            campologin.setCustomValidity('')
        }
    })
}

function vSenha(){
    var senha1	=	document.getElementById('input-senha');
    var senha2	=	document.getElementById('input-senha2');

    if(senha1.value != senha2.value)
        senha2.setCustomValidity('Senhas não conferem!')
    else
        senha2.setCustomValidity('')
}


function novo(){
	$('.loader').show();
	$.ajax({
		url: "cadastro.php",
		type: "POST",
		success: function(retorno){
			$('#entry').hide();
			$('.loader').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
		}
	})
}

function edita(cod){
	$('.loader').show();
	$.ajax({
		url: "edita.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){
			$('#entry').hide();
			$('.loader').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
		}
	})
}

function fecha(){
	$('.log').html('');
	$('#area_form').slideUp(500);
	$('#entry').fadeIn(1000);
}

function excluir(cod){	
	$.ajax({
		url: "ajax_exclui.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){
			fecha();
			$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
			chamaTabela();
		}
	})	
}

function chamaTabela() {
	$.ajax({//método ajax
		url: "tabeladados.php", //página requisitada
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
		}
	}); 
}

function carregaFoto(cod){
    $.ajax({
        url: "foto.php",
        type: "POST",
        data: {cod : cod},
        success: function(retorno){
            $('#entry').hide();
            $('.log').html('');
            $('#entry').hide().html(retorno).slideDown(500);


        }
    })
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
		
			/* Cadastrar */
			$('#cadastrar').live ('click',function(){
				$('.loader').show();
                var classificacao =	$('#input-classificacao').val();
                var nome		=	$('#input-nome').val();
                var descricao	=	$('#input-descricao').val();
                var unidade		=	$('#input-unidade').val();
                
                var cor			=	$('#input-cor').val();
                var tamanho		=	$('#input-tamanho').val();
                var frete		=	$('#input-frete').val();
                var lancamento	=	$('#input-lancamento').val();
                var peso		=	$('#input-peso').val();
                var marca		=	$('#input-marca').val();
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado

						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {nome : nome, classificacao: classificacao, descricao : descricao, unidade : unidade, cor: cor, tamanho: tamanho, frete: frete, lancamento: lancamento, peso: peso, marca: marca},
							success: function(retorno){ //em caso de sucesso
								$('.loader').hide();
								fecha();
                               	$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
								chamaTabela();
							},
							error: (function(retorno) {
                                fecha();
                                $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                                chamaTabela();

							})
						});
				    }else console.log("invalid form");

			}); /* fim Cadastrar */		
			
			/*  Salvar */
			$('#salvar').live ({
				click: function(){

					var cod	=	$('#input-cod').val();
	                var classificacao	=	$('#input-classificacao').val();
	                var nome		=	$('#input-nome').val();
	                var descricao	=	$('#input-descricao').val();
	                var unidade		=	$('#input-unidade').val();
	                
	                var cor		=	$('#input-cor').val();
	                var tamanho		=	$('#input-tamanho').val();
	                var frete		=	$('#input-frete').val();
	                var lancamento		=	$('#input-lancamento').val();
	                var peso		=	$('#input-peso').val();
	                var marca		=	$('#input-marca').val();


                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                    	$('.loader').show();
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, nome : nome, classificacao: classificacao, descricao : descricao, unidade : unidade, cor: cor, tamanho: tamanho, frete: frete, lancamento: lancamento, peso: peso, marca: marca},
                            success: function(retorno){ //em caso de sucesso
                            	$('.loader').hide();
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