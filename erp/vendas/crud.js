var	ajaxloader	=	'carregando';
var	errorloader =	'erro';		


function novo(){
    $.ajax({
        url: "cadastro.php",
        type: "POST",
        success: function(retorno){
            $('#entry').hide();
            $('.log').html('');
            $('#entry2').hide().html('');
            $('#entry').hide().html(retorno).slideDown(500);
        }
    })
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

function edita(cod){
	$.ajax({
		url: "edita.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){			
			$('#entry').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
			chamaProdutos(cod);
		}
	})
}

function pagamentos(cod){
	$.ajax({
		url: "pagamentos.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){			
			$('#entry').hide();
			$('.log').html('');
			$('#entry').hide().html(retorno).slideDown(500);
			chamaProdutos(cod);
		}
	})
}

function fecha(){
	$('#entry2').hide();
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

function excluir2(cod){
	var venda = $('#input-cod').val();	
	$.ajax({
		url: "ajax_exclui2.php",
		type: "POST",
		data: {cod : cod},
		success: function(retorno){
			$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
			chamaProdutos(venda);
            $.post("atualiza_total.php",{cod: venda},
					function(retorno){
						$('#input-total').val(retorno);
					}
		)
		}
	})	
}
function chamaTabela2(codigo) {
	var cod = $('#buscaCodigo').val();
	var unidade = $('#buscaUnidade').val();
	var cliente = $('#buscaCliente').val();
	var data = $('#buscaData').val();
	
	$.ajax({//método ajax
		url: "tabeladados.php?page="+codigo, //página requisitada
		type: "POST",
		data: {cod: cod, cliente: cliente, data: data, unidade: unidade},
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
		data: {cod: '', data: '', cliente: '', unidade: ''},
		success: function(retorno){ //em caso de sucesso
			$('#entry2').hide();
			$("#entry").hide().html(retorno).fadeIn(1000);
            $("#"+codigo).addClass("active");
            $("#teste").val(codigo);
		}
	}); 
}

function chamaProdutos(venda) {
	$.ajax({//método ajax
		url: "lista_produtos.php", //página requisitada
		type: "POST",
		data: {venda : venda},
		success: function(retorno){ //em caso de sucesso
			$("#entry2").hide().html(retorno).fadeIn(1000);
		}
	}); 
}

function recebe_pag(campo, cliente, venda) {
	data = $(campo).val();
	cod = campo.substring(4);
	$.ajax({//método ajax
		url: "ajax_receber_pag.php", //página requisitada
		type: "POST",
		data: {data: data, cod: cod},
		success: function(retorno){ //em caso de sucesso
			chamaRecebimentos(cliente, venda);
		}
	}); 
}

function exclui_pag(campo, cliente, venda) {
	cod = campo.substring(4);
	$.ajax({//método ajax
		url: "ajax_excluir_pag.php", //página requisitada
		type: "POST",
		data: {cod: cod},
		success: function(retorno){ //em caso de sucesso
			chamaRecebimentos(cliente, venda);
		}
	}); 
}

function removeParcela(parcela) {
	var cod = $('#input-cod').val();
	$.ajax({//método ajax
		url: "remove_parcela.php", //página requisitada
		type: "POST",
		data: {cod : cod, parcela: parcela},
		success: function(retorno){ //em caso de sucesso
			pagamentos(retorno);
		}
	}); 
}

function removeCrediario(venda) {
	$.ajax({//método ajax
		url: "remove_crediario.php", //página requisitada
		type: "POST",
		data: {venda: venda},
		success: function(retorno){ //em caso de sucesso
			pagamentos(venda);
		}
	}); 
}

function janelaConfirma (codigo) {
    $("#myModal").modal ("show");
    $("#myModal #valor").val(codigo);
}

function janelaConfirma2 (codigo) {
    $("#myModal2").modal ("show");
    $("#myModal2 #valor2").val(codigo);
}

function janelaAlerta(mensagem) {	
	$('#myModal3 #myModalLabel3').html('Atenção');
	$('#myModal3 .modal-body').html('<p>'+mensagem+'</p>');	
    $("#myModal3").modal ("show");
}

function janelaClientes () {
	$.post('cad_clientes.php','',function(retorno){
		$("#modalClientes .divDialogElements").html(retorno);
		$('#input-nome').focus();
		$('input').click(function(){
			$(this).focus();
		})
	})	
    $("#modalClientes").modal ("show");
}

function localizar_Produto () {
    $.post('localizar_produto.php','',function(retorno){
        $('#input-nome').focus();
        $("#modalLocalizar .modal-body").html(retorno);

    })
    $("#modalLocalizar").modal ("show");
}

function localizar_Produto2 () {
    var nome = $('#nome').val();
    var cor = $('#cor').val();
    var tamanho = $('#tamanho').val();
    var marca = $('#marca').val();
    var localizar = 1;

    $.post('localizar_produto.php',{nome: nome, cor: cor, tamanho: tamanho, marca: marca, localizar: localizar},function(retorno){
        $('#input-nome').focus();
        $("#modalLocalizar .modal-body").html(retorno);

    })
    $("#modalLocalizar").modal ("show");
}



function localizar_Produto3 (codigo) {
    novo2(codigo);
}

function localizar_produto4(cod){
    $.ajax({
        url: "busca_produto2.php",
        type: "POST",
        data: {cod : cod},
        success: function(retorno){
          //$("#input-produto").select2({data: dados });
          //$("#input-produto").val(dados).trigger("change");
          //  $("#input-produto").select2("val", dados);
            var dados = retorno.split("#");
            $("#input-produto").select2("data", {id: dados[0], text: dados[1]});



        }
    })
}

function janelaProdutos () {
	$.post('cad_produtos.php','',function(retorno){
		$("#modalProdutos .divDialogElements").html(retorno);
		$('#nome').focus();
		$('input, select').click(function(){
			$(this).focus();
		})
		
	})	
    $("#modalProdutos").modal ("show");
}

function janelaProdutos2 (venda) {
	$.post('cad_produtos.php',{venda: venda},function(retorno){
		$("#modalProdutos .divDialogElements").html(retorno);
		$('#nome').focus();
		$('input, select').click(function(){
			$(this).focus();
		})
		
	})	
    $("#modalProdutos").modal ("show");
}

function janelaResumo () {
	var pagina =  'resumo.php?op=1#dados';
	$('#modalResumo').on('show', function () {
        $('iframe').attr("src",pagina);      
	});
    $("#modalResumo").modal("show");
}

function chamaRecebimentos (codigo) {
    var pagina =  'recebimentos.php?codigo='+codigo;
    $('#modalHistorico').on('show', function () {
        $('iframe').attr("src",pagina);
    });
    $("#modalHistorico").modal("show");
}

function gravaProduto(){
            
			var nome		=	$('#nome').val();
            var descricao	=	$('#descricao').val();
            var cor			=	$('#cor').val();
            var tamanho		=	$('#tamanho').val();
            var marca		=	$('#marca').val();
            var quantidade	=	$('#quantidade').val();
            var preco		=	$('#preco').val();
            var venda		=	$('#venda').val();
            
                if($("form")[0].checkValidity()) {  //verificando se o form foi validado
					$.ajax({//método ajax
						url: "ajax_cad_produtos.php", //página requisitada
						type: "POST",
						data: {'nome' : nome, 'descricao' : descricao, 'cor': cor, 'tamanho': tamanho, 'marca': marca, 'quantidade': quantidade, 'preco': preco},
						success: function(retorno){ //em caso de sucesso
							$("#modalProdutos").modal ('hide');
							if(venda == '')
								novo();
							else
								edita(venda);
						},
						error: (function(retorno) {
                            $("#modalProdutos").modal ('hide');
		                    $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
		                    chamaTabela(1);
						})
					});
			    }else console.log("invalid form");
}

function gravaCliente(){
	var nome		=	$('#input-nome').val();
    var email		=	$('#input-email').val();
    var endereco	=	$('#input-endereco').val();
    var numero		=	$('#input-numero').val();
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
				url: "ajax_cad_clientes.php", //página requisitada
				type: "POST",
				data: {nome : nome, email: email, endereco : endereco, numero: numero, complemento: complemento, cidade : cidade, estado : estado, cep : cep, telefone : telefone, renda: renda, limite: limite, cpf: cpf, identidade: identidade, conjuge: conjuge, civil: civil, data_nasc: data_nasc, observacao: observacao},
				success: function(retorno){ //em caso de sucesso
					$("#modalClientes").modal ('hide');
					novo();
				},
				error: (function(retorno) {
                    $("#modalClientes").modal ('hide');
                    $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                    chamaTabela(1);

				})
			});
	    }else console.log("invalid form");
}


function confirma () {	
    var codigo =  $("#myModal #valor").val();    	
    $("#myModal").modal ('hide');
    excluir(codigo);
};

function confirma2 () {	
    var codigo =  $("#myModal2 #valor2").val();    	
    $("#myModal2").modal ('hide');
    excluir2(codigo);
};

		$(document).ready(function(){
			
			//var	ajaxloader	=	'<img src="images/ajax-loader.gif" height="16px" width="16px">';
			//var	errorloader =	'<img src="images/erro.gif" height="16px" width="16px">'; 
				

			/*chamaTabela(1);*/
            var tela_edita = $("#tela_edita").val();
            if(tela_edita == 1)
            {
                var cod2 = $("#cod2").val();
                edita(cod2);
            }
            else
                novo();
			/* Função para atualizar a tabela ou chamar ela.*/
		
			/* Cadastrar */
			$('#cadastrar').live ('click',function(){
                var cliente		=	$('#input-cliente').val();
                var data		=	$('#input-data').val();
                var observacao	=	$('#input-observacao').val();
				var produto 	=   $("#input-produto").val();
				var preco 		=   $("#input-preco").val();
				var quantidade 	=   $("#input-quantidade").val();

                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
						$('.loader').show();
                        $.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {cliente : cliente, data: data, observacao : observacao, produto: produto, preco : preco, quantidade: quantidade},
							success: function(retorno){ //em caso de sucesso
								$('.loader').hide();
                                edita(retorno);
                               	//$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
								//chamaTabela();

							},
							error: (function(retorno) {
								$('.loader').hide();
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
					var cod			=	$('#input-cod').val();
					var cliente		=	$('#input-cliente').val();
	                var data		=	$('#input-data').val();
	                var observacao	=	$('#input-observacao').val();
	                var parcelas	=	$('#input-parcelas').val();
	                var vencimento	=	$('#input-vencimento').val();


                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "ajax_editar.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, cliente : cliente, data: data, observacao : observacao, parcelas: parcelas, vencimento: vencimento},
                            success: function(retorno){ //em caso de sucesso
                                fecha();
                                $('.log').html('<div class="alert alert-info">Dados modificados com sucesso</div>');
                                edita(retorno);
                                //chamaTabela();
                            },
                            error: (function() {
                                $(".log").html('<div class="alert alert-error">Falha ao editar</div>'); // seta a frase de erro, caso falhe.
                            })
                        });
                    }else console.log("invalid form");
                }
			}); /* fim Salvar */
			
			/*  Adicionar parcela */
			$('#adicionar-parcela').live ({
				click: function(){
					var cod			=	$('#input-cod').val();
					var forma		=	$('#input-formaP').val();
	                var valor		=	$('#input-valorP').val();
	                var dataP		=	$('#input-dataP').val();	                
	                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "add_parcela.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, forma : forma, valor: valor, dataP: dataP},
                            success: function(retorno){ //em caso de sucesso
                                if(retorno.substring(0,5)=='ERRO1'){
                                	janelaAlerta('Valor inválido');
                                	dados = retorno.split('#');
									venda = retorno.substring(6);
									pagamentos(venda);
                                }
                                else if(retorno.substring(0,5)=='ERRO2'){                                	
                                	dados = retorno.split('#');
                                	janelaAlerta('LIMITE ULTRAPASSADO. <b>VALOR PARA CREDIÁRIO DISPONÍVEL: ' + dados[1] + '</b>');
									venda = dados[2];
									pagamentos(venda);
                                }                                
                                else{                                
	                                $('.log').html('<div class="alert alert-info">Parcela adicionada sucesso</div>');
	                                pagamentos(retorno);	                                
	                            }
                            },
                            error: (function() {
                                $(".log").html('<div class="alert alert-error">Falha ao editar</div>'); // seta a frase de erro, caso falhe.
                            })
                        });
                    }else console.log("invalid form");
                }
			}); /* fim adicionar parcela */
			
			
			/*  Adicionar cartao credito */
			$('#adicionar-credito').live ({
				click: function(){
					var cod			=	$('#input-cod').val();
					var operadoraC	=	$('#input-operadoraC').val();
					var parcelasC	=	$('#input-parcelasC').val();
	                var totalC		=	$('#input-totalC').val();
	                var dataC		=	$('#input-dataC').val();
	                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "add_credito.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, operadoraC: operadoraC, parcelasC : parcelasC, totalC: totalC, dataC: dataC},
                            success: function(retorno){ //em caso de sucess
                                if(retorno.substring(0,5)=='ERRO1'){
                                	janelaAlerta('Valor inválido');
									venda = retorno.substring(6);
									pagamentos(venda);
                                }
                                else{                                
	                                $('.log').html('<div class="alert alert-info">Parcela adicionada sucesso</div>');
	                                pagamentos(retorno);	                                
	                            }
                            },
                            error: (function() {
                                $(".log").html('<div class="alert alert-error">Falha ao editar</div>'); // seta a frase de erro, caso falhe.
                            })
                        });
                    }else console.log("invalid form");
                }
			}); /* fim adicionar cartao credito */
			
			/*  Adicionar crediario */
			$('#adicionar-crediario').live ({
				click: function(){
					var cod			=	$('#input-cod').val();
					var parcelasC	=	$('#input-parcelasC').val();
	                var totalC		=	$('#input-totalC').val();
	                var dataC		=	$('#input-dataC').val();
	                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
                        $.ajax({//método ajax
                            url: "add_crediario.php", //página requisitada
                            type: "POST",
                            data: {cod: cod, parcelasC : parcelasC, totalC: totalC, dataC: dataC},
                            success: function(retorno){ //em caso de sucess
                                if(retorno.substring(0,5)=='ERRO1'){
                                	janelaAlerta('Valor inválido');
									venda = retorno.substring(6);
									pagamentos(venda);
                                }
                                else if(retorno.substring(0,5)=='ERRO2'){                                	
                                	dados = retorno.split('#');
                                	janelaAlerta('LIMITE ULTRAPASSADO. <b>VALOR PARA CREDIÁRIO DISPONÍVEL: ' + dados[1] + '</b>');
									venda = dados[2];
									pagamentos(venda);
                                }
                                else if(retorno.substring(0,5)=='ERRO3'){                                	
                                	dados = retorno.split('#');
                                	janelaAlerta('O VALOR MÍNIMO PARA A PARCELA É DE R$ ' + dados[1] + '</b>');
									venda = dados[2];
									pagamentos(venda);
                                }
                                else if(retorno.substring(0,5)=='ERRO4'){                                	
                                	dados = retorno.split('#');
                                	janelaAlerta('O VALOR MÁXIMO DA PARCELA PARA ESTE CLIENTE É DE R$ ' + dados[1] + '</b>');
									venda = dados[2];
									pagamentos(venda);
                                }
                                else{                                
	                                $('.log').html('<div class="alert alert-info">Parcela adicionada sucesso</div>');
	                                pagamentos(retorno);	                                
	                            }
                            },
                            error: (function() {
                                $(".log").html('<div class="alert alert-error">Falha ao editar</div>'); // seta a frase de erro, caso falhe.
                            })
                        });
                    }else console.log("invalid form");
                }
			}); /* fim adicionar crediario */
			
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