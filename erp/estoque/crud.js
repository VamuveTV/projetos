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

function chamaTabela2(codigo) {
    var cod = $('#buscaCodigo').val();
    var produto = $('#buscaProduto').val();
    var centro_custo = $('#buscaCentro_custo').val();
    var unidade = $('#buscaUnidade').val();
    var marca = $('#buscaMarca').val();
    var cor = $('#buscaCor').val();
    var tamanho = $('#buscaTamanho').val();

    $.ajax({//método ajax
        url: "tabeladados.php?page="+codigo, //página requisitada
        type: "POST",
        data: {cod: cod, produto: produto, centro_custo: centro_custo, unidade: unidade, marca: marca, cor: cor, tamanho: tamanho},
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

function chamaResumo(codigo) {
    var cod = $('#buscaCodigo').val();
    var produto = $('#buscaProduto').val();

    $.ajax({//método ajax
        url: "resumo.php?page="+codigo, //página requisitada
        type: "POST",
        data: {cod: cod, produto: produto},
        success: function(retorno){ //em caso de sucesso
            $("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
        }
	}); 
}

// localizar produto
function localizar_Produto () {
    $.post('localizar_produto.php','',function(retorno){
        $('#input-nome').focus();
        $("#modalLocalizar .modal-body").html(retorno);

    })
    $("#modalLocalizar").modal ("show");
}

function localizar_Produto2 () {
    var nome = $('#nome').val();
    var marca = $('#marca').val();
    var localizar = 1;

    $.post('localizar_produto.php',{nome: nome, marca: marca, localizar: localizar},function(retorno){
        $('#input-nome').focus();
        $("#modalLocalizar .modal-body").html(retorno);

    })
    $("#modalLocalizar").modal ("show");
}

function localizar_Produto3 (codigo) {
    novo2(codigo);
}

function novo2(codigo){
    var localizar = 1;
    $.ajax({
        url: "cadastro.php",
        type: "POST",
        data: {codigo : codigo, localizar: localizar},
        success: function(retorno){
            $("#modalLocalizar").modal ("hide");
            $('#entry').hide();
            $('.log').html('');
            $('#entry2').hide().html('');
            $('#entry').hide().html(retorno).slideDown(500);
        }
    })
}

//fim localizar produto


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
			
			$('#addItem').live ({
                click: function(){
                	$.post('addItem.php',{},function(dados){
                		var conteudo = dados;
                		$('#itens tr:last').after(conteudo);
                	})
					                  
                }
            });

			/* Cadastrar */
			$('#cadastrar').live ('click',function(){                

                var tamanho = new Array();
				$("select[name='tamanho[]']").each(function(){
				    if($(this).val() != '')
				    	tamanho.push($(this).val());
				});
				
				var cor = new Array();
				$("select[name='cor[]']").each(function(){
				    if($(this).val() != '')
				    	cor.push($(this).val());
				});

                var unidade = new Array();
                $("#unidades :selected" ).each( function( i, selected ) {
                    unidade[i] = $(selected).val();

                });

                var unidade2 = new Array();
                $("select[name='unidades2[]']").each(function(){
                    unidade2.push($(this).val());

                });

                var quantidade = new Array();
				$("input[name='quantidade[]']").each(function(){
				    if($(this).val() != '')
				    	quantidade.push($(this).val());
				});
				
				var produto		=	$('#input-produto').val();
				var custo		=	$('#valor-custo').val();
				var venda		=	$('#valor-venda').val();
				var centro		=	$('#input-centro').val();
				                
                if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                		$('.loader').show();
						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {'produto': produto, 'centro': centro, 'custo': custo, 'venda': venda, 'unidade[]' : unidade, 'unidade2[]' : unidade2, 'cor[]': cor, 'tamanho[]': tamanho, 'quantidade[]': quantidade},
							success: function(retorno){ //em caso de sucesso
								$('.loader').hide();
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
					$('.loader').show();

					var cod			=	$('#input-cod').val();
	                var produto     =	$('#input-produto').val();
	                var quantidade	=	$('#input-quantidade').val();
	                var centro	    =	$('#input-centro').val();
	                var data	    =	$('#input-data').val();
	                var valor	    =	$('#input-valor').val();
	                var venda	    =	$('#input-venda').val();

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, produto : produto, quantidade: quantidade, centro: centro, data: data, valor: valor, venda: venda},
                            success: function(retorno){ //em caso de sucesso
                            	$('.loader').hide();
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