<?php

    $formulario = file_get_contents("templete.html");

    if (isset($_REQUEST['bPesquisar'])){
        $cep = $_REQUEST['cep'];

        $curl = curl_init();
            curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://viacep.com.br/ws/$cep/json"
        ]);

        $resposta = curl_exec($curl);
        curl_close($curl);

        $dados = json_decode($resposta, true);
        if (isset($dados["logradouro"])) {
            $endereco = "Logradouro: " . $dados["logradouro"];
            $endereco = $endereco . "<br>" . "Bairro:"  . $dados["bairro"];
            $endereco = $endereco . "<br>" . "Cidade:" . $dados["localidade"];
            $endereco = $endereco . "<br>" . "Estado:" . $dados["uf"]; 
        }else {
            $endereco = "Cep inválido ou inexistente.";
        }
   
        
        $formulario = str_replace("<!--ENDERECO-->", $endereco, $formulario);
    }
    
    echo $formulario;
?>