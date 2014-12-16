<!-- Declaração do formulário -->  
<form target="pagseguro" method="post"   
action="https://pagseguro.uol.com.br/v2/checkout/payment.html">  
      
    <!-- Campos obrigatórios -->  
    <input type="hidden" name="receiverEmail" value="fernando@zarbsolution.com.br">  
    <input type="hidden" name="currency" value="BRL">  
      
    <!-- Itens do pagamento (ao menos um item é obrigatório) -->  
    <input type="hidden" name="itemId1" value="0001">  
    <input type="hidden" name="itemDescription1" value="Curso Android">  
    <input type="hidden" name="itemAmount1" value="800.00">  
    <input type="hidden" name="itemQuantity1" value="1">  
    <input type="hidden" name="itemWeight1" value="0000">  
      
    <input type="hidden" name="itemId2" value="0002">  
    <input type="hidden" name="itemDescription2" value="Curso jQuery">  
    <input type="hidden" name="itemAmount2" value="450.00">  
    <input type="hidden" name="itemQuantity2" value="1">  
    <input type="hidden" name="itemWeight2" value="0000">  
      
    <!-- Código de referência do pagamento no seu sistema (opcional) -->  
    <input type="hidden" name="reference" value="REF0001">  
      
    <!-- Informações de frete (opcionais) -->  
    <input type="hidden" name="shippingType" value="1">  
    <input type="hidden" name="shippingAddressPostalCode" value="01452002">  
    <input type="hidden" name="shippingAddressStreet" value="Av. Brig. Faria Lima">  
    <input type="hidden" name="shippingAddressNumber" value="1384">  
    <input type="hidden" name="shippingAddressComplement" value="5o andar">  
    <input type="hidden" name="shippingAddressDistrict" value="Jardim Paulistano">  
    <input type="hidden" name="shippingAddressCity" value="Sao Paulo">  
    <input type="hidden" name="shippingAddressState" value="SP">  
    <input type="hidden" name="shippingAddressCountry" value="BRA">  
      
    <!-- Dados do comprador (opcionais) -->  
    <input type="hidden" name="senderName" value="Zezim Comprador">  
    <input type="hidden" name="senderAreaCode" value="11">  
    <input type="hidden" name="senderPhone" value="56273440">  
    <input type="hidden" name="senderEmail" value="comprador@uol.com.br">  
      
    <!-- submit do form (obrigatório) -->  
    <input type="image" name="submit"   
    src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif"   
    alt="Pague com PagSeguro">  
      
</form>  
