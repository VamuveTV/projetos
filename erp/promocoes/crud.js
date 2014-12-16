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
	$.ajax({
		url: "cadastro.php",
		type: "POST",
		success: function(retorno){
			$('#entry').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
		}
	})
}

function edita(cod){
	$.ajax({
		url: "edita.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){
			$('#entry').hide();
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

function chamaTabela2(codigo) {
    var cod = $('#buscaCodigo').val();
    var produto = $('#buscaProduto').val();
    var unidade = $('#buscaUnidade').val();
    var data_inicio = $('#buscaDataInicio').val();
    var data_fim = $('#buscaDataFim').val();

    $.ajax({//método ajax
        url: "tabeladados.php?page="+codigo, //página requisitada
        type: "POST",
        data: {cod: cod, produto: produto, unidade: unidade, data_inicio: data_inicio, data_fim: data_fim},
        success: function(retorno){ //em caso de sucesso
            $("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
        }
    });
}

function chamaTabela(codigo) {
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
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
		
			/* Cadastrar */
			$('#cadastrar').live ('click',function(){

				var unidade		=	$('#input-unidade').val();
                var produto		=	$('#input-produto').val();
                var data_inicio	=	$('#input-dataini').val();
                var data_fim	=	$('#input-datafim').val();
                var preco		=	$('#input-preco').val();
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado

						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {unidade: unidade, produto: produto, data_inicio: data_inicio, data_fim: data_fim, preco: preco},
							success: function(retorno){ //em caso de sucesso
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

					var cod			=	$('#input-cod').val();
					var unidade		=	$('#input-unidade').val();
	                var produto		=	$('#input-produto').val();
	                var data_inicio	=	$('#input-dataini').val();
	                var data_fim	=	$('#input-datafim').val();
	                var preco		=	$('#input-preco').val();

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, unidade: unidade, produto: produto, data_inicio: data_inicio, data_fim: data_fim, preco: preco},
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