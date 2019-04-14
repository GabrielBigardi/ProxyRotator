<?php
set_time_limit(0); //Desativa o limite de tempo de execução do arquivo


//$d = 0; //Variável inicial
//while($d == 0){ //Enquanto essa variável for 0
do{
	//Seleciona o Proxy - Funcionando
	$arquivo = "socks.txt";
	$fp = fopen($arquivo, "r");
	$conteudo = fread($fp, filesize($arquivo));
	fclose($fp);
	$separar = explode("\n", $conteudo);
	$rand1 = rand(0, 18376); //Quantidade de socks
	$proxy = $separar[$rand1];
	//Fim de seleção de Proxy
	
	
	
	//Request HTTPS usando o SOCKS selecionado - Não funcionando direito
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://postman-echo.com/get');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$data = curl_exec($ch);
	//Fim do request
	
	$decodeddata = stristr($data, '"host":"postman-echo.com"') ? "Sucesso" : "Erro";
	
	//echo $decodeddata;
	
	if($decodeddata == "Erro"){
		echo "";
	}else{
		echo "$proxy";
	}
	
	
	
	////Checagem de dados - Se não retornar nada deu falha, então abre uma nova conexão para esta url
	//if ($data === false)
	//{
	//	$d = 0;
	//	curl_setopt($ch, CURLOPT_URL, 'http://localhost/tibiaglobal/includes/proxy.php');
	//	curl_setopt($ch, CURLOPT_PROXY, '');
	//	$retry = curl_exec($ch);
	//	
	//}
	//else //Se retornar algo então o proxy está bom
	//{
	//	echo $proxy;
	//	$d = 1;
	//}
	////Fim da checagem
	
	
} while ($decodeddata == "Erro");
?>