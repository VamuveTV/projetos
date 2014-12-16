var	ajaxloader	=	'carregando';
var	errorloader =	'erro';


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
	var cpf = $('#buscaCpf').val();

	$.ajax({//método ajax
		url: "recebimentos.php?page="+codigo, //página requisitada
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
		url: "recebimentos.php?page="+codigo, //página requisitada
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
		url: "recebimentos.php?", //página requisitada
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
           // chamaRecebimentos();
			/* Função para atualizar a tabela ou chamar ela.*/
		

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
                    chamaTabela2(this.id)


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
                        chamaTabela2(pagina2);


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
                        chamaTabela2(pagina2);
                    }

                }
            }); /* fim da paginação*/




        }); /* fim do document ready*/