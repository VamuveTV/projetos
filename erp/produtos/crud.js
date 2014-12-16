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

function editarVarios(){
	var produtos = new Array();
	$("input[type=checkbox][name='cod[]']:checked").each(function(){
	    produtos.push($(this).val());
	});
	
	$('.loader').show();
	$.ajax({
		url: "edita_varios.php",
		type: "POST",
		data: {'produtos[]': produtos},
		success: function(retorno){
			$('#entry').hide();
			$('.loader').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
		}
	})
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
	$('.loader').show();
	$.ajax({
		url: "ajax_exclui.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){
			$('.loader').hide();
			fecha();
			$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
			chamaTabela(1);
		}
	})	
}

function chamaTabela(codigo) {
	var cod = nome = un = '';
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		type: "POST",
		data: {cod: cod, nome: nome, un: un},
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
		}
	}); 
}

function chamaTabela2(codigo) {
	var cod = $('#buscaCodigo').val();
	var nome = $('#buscaNome').val();
	var un = $('#buscaUnidade').val();
	
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		type: "POST",
		data: {cod: cod, nome: nome, un: un},
		success: function(retorno){ //em caso de sucesso
			$("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
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
			
			/* Função para atualizar a tabela ou chamar ela.*/
			chamaTabela(1);
						
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
            
            $('#addItem').live ({
                click: function(){
                	$.post('addItem.php',{},function(dados){
                		var conteudo = dados;
                		$('#itens tr:last').after(conteudo);
                	})
					                  
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