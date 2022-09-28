<?php

    $formulario = file_get_contents("templete.html");

    if (isset($_REQUEST['bPesquisar'])){
        $real = $_REQUEST['real'];

        $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://economia.awesomeapi.com.br/json/last/USD-BRL"
        ]);

        $resposta = curl_exec($curl);
        curl_close($curl);

        $dados = json_decode($resposta, true);
        $vrDolar = 0;
        $vrTotal = 0;
        if (isset($dados["USDBRL"])) {
            $vrDolar = $dados["USDBRL"]["high"];
            $vrTotal = $real / $vrDolar;
            $vrTotal = number_format($vrTotal, 2, ',', '.');
            $cotacao = "<h3>US$ Total = $vrTotal<br>";
            $cotacao = $cotacao . "(Cotação Atual = $vrDolar)</h3>";
        }else {
            $cotacao = "Coverção inválida.";
        }
   
        
        $formulario = str_replace("<!--DADOS-->", $cotacao, $formulario);
    }
    
    echo $formulario;
?>