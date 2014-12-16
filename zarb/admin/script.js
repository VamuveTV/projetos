var div;

function loadXMLDoc(url)
{
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("POST", url, true);
        req.send(null);
    // Procura por uma versão ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
        	req.onreadystatechange = processReqChange;
            req.open("POST", url, true);
            req.send();
        }
    }
}

function processReqChange()
{
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req.status == 200) {
            // procura pela div id="novo" e insere o conteudo
            // retornado nela, como texto HTML\
            
            	document.getElementById(div).innerHTML = req.responseText;
            	if(div=='logcpf')
            	{
                if(req.responseText.length > 100){
                  cadastro.cpf.value='';
                  cadastro.cpf.focus();
                }
              }
        } else {
            alert("Houve um problema ao obter os dados:\n" + req.statusText);
        }
    }
}

function valida_cpf2(cpf)
{
  div = 'logcpf';
  
	loadXMLDoc("valida_cpf.php?cpf="+cpf);
}

function busca_cidades(local,estado)
{
  div = local;
  loadXMLDoc("busca_cidades.php?estado="+estado);
}

//funcao que busca as cidades semelhante a busca_cidades() porem coloca BH como default
function busca_cidades2(local,estado)
{
  div = local;
  loadXMLDoc("busca_cidades2.php?estado="+estado);
}
