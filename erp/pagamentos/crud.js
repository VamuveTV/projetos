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
	var endereco = $('#buscaEndereco').val();
	var telefone = $('#buscaTelefone').val();
	var email = $('#buscaEmail').val();
	var cpf = $('#buscaCpf').val();
	
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		type: "POST",
		data: {cod: cod, nome: nome, cpf: cpf},
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
		data: {cod: '', nome: '', cpf: ''},
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
		}
	}); 
}

function chamaRecebimentos(cliente) {
	$.ajax({//método ajax
		url: "recebimentos.php", //página requisitada
		type: "POST",
		data: {cliente: cliente},
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
		}
	}); 
}

function recebe_pag(campo, cliente) {
	data = $(campo).val();
	cod = campo.substring(4);
	$.ajax({//método ajax
		url: "ajax_receber_pag.php", //página requisitada
		type: "POST",
		data: {data: data, cod: cod},
		success: function(retorno){ //em caso de sucesso
			chamaRecebimentos(cliente);
		}
	}); 
}

function exclui_pag(campo, cliente) {
	cod = campo.substring(4);
	$.ajax({//método ajax
		url: "ajax_excluir_pag.php", //página requisitada
		type: "POST",
		data: {cod: cod},
		success: function(retorno){ //em caso de sucesso
			chamaRecebimentos(cliente);
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

                var nome		=	$('#input-nome').val();
                var email		=	$('#input-email').val();
                var endereco	=	$('#input-endereco').val();
                var numero		=	$('#input-numero').val();
                var bairro		=	$('#input-bairro').val();
                var complemento	=	$('#input-complemento').val();
                var cidade		=	$('#input-cidade').val();
                var estado		=	$('#input-estado').val();
                var cep			=	$('#input-cep').val();
                var telefone	=	$('#input-telefone').val();
                var renda		=	$('#input-renda').val();
                var limite		=	$('#input-limite').val();
                var cpf			=	$('#input-cpf').val();
                var identidade	=	$('#input-identidade').val();
                var conjuge		=	$('#input-conjuge').val();
                var civil		=	$('#input-civil').val();
                var data_nasc	=	$('#input-data').val();
                var observacao	=	$('#input-observacao').val();
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado

						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {nome : nome, email: email, endereco : endereco, bairro: bairro, numero: numero, complemento: complemento, cidade : cidade, estado : estado, cep : cep, telefone : telefone, renda: renda, limite: limite, cpf: cpf, identidade: identidade, conjuge: conjuge, civil: civil, data_nasc: data_nasc, observacao: observacao},
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
					var email	=	$('#input-email').val();
					var endereco	=	$('#input-endereco').val();
					var numero		=	$('#input-numero').val();
					var bairro		=	$('#input-bairro').val();
                	var complemento	=	$('#input-complemento').val();
					var cidade	=	$('#input-cidade').val();
	                var estado	=	$('#input-estado').val();
	                var cep	=	$('#input-cep').val();
                    var telefone	=	$('#input-telefone').val();
                    var renda		=	$('#input-renda').val();
	                var limite		=	$('#input-limite').val();
	                var cpf			=	$('#input-cpf').val();
	                var identidade	=	$('#input-identidade').val();
	                var conjuge		=	$('#input-conjuge').val();
	                var civil		=	$('#input-civil').val();
	                var data_nasc	=	$('#input-data').val();
	                var observacao	=	$('#input-observacao').val();
                

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, nome : nome, email: email, endereco : endereco, bairro: bairro, numero: numero, complemento: complemento, cidade : cidade, estado : estado, cep : cep, telefone : telefone, renda: renda, limite: limite, cpf: cpf, identidade: identidade, conjuge: conjuge, civil: civil, data_nasc: data_nasc, observacao: observacao},
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