<?php
if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
    //Todo resto do código iremos inserir aqui.

    $email = 'fernando@zarbsolution.com.br';
    $token = '7C4E0B9ABA0F4D8BB306F6DF82690FB0';

    $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
        //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção
        $n = date("dmYhis");
        mail('fernando@zarbsolution.com.br', "Log Notificações $n", "Unauthorized");
        exit;//Mantenha essa linha
    }
    $transaction = simplexml_load_string($transaction);
    
    $data = $transaction->date;
    $code = $transaction->code;
    $ref = $transaction->reference;
    $status = $transaction->status;
    $preco = $transaction->grossAmount;
    $cliente = $transaction->sender->name;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    $assunto = "Pagamento $ref";
    $mensagem = "<h1>Notificação referente ao pagamento $ref</h1>";
    $mensagem.= "Data: $data<br>";
    $mensagem.= "Status: $status<br>";
    $mensagem.= "Preço: $preco<br>";
    $mensagem.= "Cliente: $cliente<br>";
    $mensagem.= "Code: $code";
    
    mail("fernando@zarbsolution.com.br", $assunto, $mensagem, $headers);
}