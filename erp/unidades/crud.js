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
			chamaTabela(1);
		}
	})	
}

function chamaTabela2(codigo) {
	var cod = $('#buscaCodigo').val();
	var nome = $('#buscaNome').val();
	var sigla = $('#buscaSigla').val();
	
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		type: "POST",
		data: {cod: cod, nome: nome, sigla: sigla},
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
		type: "POST",
		data: {cod: '', nome: '', sigla: ''},
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
				

			chamaTabela(1);
			/* Função para atualizar a tabela ou chamar ela.*/
		
			/* Cadastrar */
			$('#cadastrar').live ('click',function(){

                var nome			=	$('#input-nome').val();
                var sigla			=	$('#input-sigla').val();
                var magento			=	$('#input-magento').val();
                var url				=	$('#input-url').val();
                var usuario_soap	=	$('#input-usu_soap').val();
                var senha_soap		=	$('#input-senha_soap').val();
                var servidor_bd		=	$('#input-servidor_bd').val();
                var usuario_bd		=	$('#input-usu_bd').val();
                var senha_bd		=	$('#input-senha_bd').val();
                var bd				=	$('#input-bd').val();
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado

						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {nome : nome, sigla: sigla,magento: magento,url: url,usuario_soap: usuario_soap,senha_soap: senha_soap,servidor_bd: servidor_bd,usuario_bd: usuario_bd,senha_bd: senha_bd, bd: bd},
							success: function(retorno){ //em caso de sucesso
								fecha();
                               	$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
								chamaTabela(1);
							},
							error: (function(retorno) {
                                fecha();
                                $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                                chamaTabela(1);

							})
						});
				    }else console.log("invalid form");

			}); /* fim Cadastrar */		
			
			/*  Salvar */
			$('#salvar').live ({
				click: function(){

					var cod	=	$('#input-cod').val();
					var nome	=	$('#input-nome').val();
					var sigla	=	$('#input-sigla').val();
					var magento			=	$('#input-magento').val();
	                var url				=	$('#input-url').val();
	                var usuario_soap	=	$('#input-usu_soap').val();
	                var senha_soap		=	$('#input-senha_soap').val();
	                var servidor_bd		=	$('#input-servidor_bd').val();
	                var usuario_bd		=	$('#input-usu_bd').val();
	                var senha_bd		=	$('#input-senha_bd').val();
	                var bd				=	$('#input-bd').val();

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, nome: nome, sigla : sigla, magento: magento,url: url,usuario_soap: usuario_soap,senha_soap: senha_soap,servidor_bd: servidor_bd,usuario_bd: usuario_bd,senha_bd: senha_bd, bd: bd},
                            success: function(retorno){ //em caso de sucesso
                                fecha();
                                $('.log').html('<div class="alert alert-info">'+retorno+'</div>');
                                chamaTabela(1);
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

            /*Paginação*/

            $('#botao .pagination').live ({
                click: function(){

                    $("#teste").val(this.id);
                    chamaTabela(this.id)


                }
            });


            $('#anterior').live ({
                click: function(){

                    var pagina = $("#teste").val();
                    var pagina2 = pagina - 1;
                    if(pagina2 > 0)
                    {
                        $('#botao .paginacao').removeClass("active");
                        $("#teste").val(pagina2);
                        chamaTabela(pagina2);


                    }


                }
            });

            $('#proximo').live ({
                click: function(){

                    var pagina = $("#teste").val();
                    pagina = parseInt(pagina);
                    var pagina2 = pagina+1;
                    var total =  $("#total").val();
                    if(pagina2 <= total)
                    {
                        $('#botao .paginacao').removeClass("active");
                        $("#teste").val(pagina2);
                        chamaTabela(pagina2);
                    }

                }
            }); /* fim da paginação*/




        }); /* fim do document ready*/