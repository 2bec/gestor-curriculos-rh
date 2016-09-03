<?php

/*
 * função __autoload()
 * carrega uma classe quando ela é necessária,
 * ou seja, quando ela é instanciada pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
    else
    {
        $classe = strtolower($classe);
        include_once "{$classe}.class.php";
    }
}

// inicia transação com o banco 'my_gcrh'
TTransaction::open('my_gcrh');

// define o arquivo para LOG
TTransaction::setLogger(new TLoggerTXT('log-login.txt'));

// armazena esta frase no arquivo de LOG
TTransaction::log("** LOGIN SISTEMA **");

$cpf = $_POST['cpf_log'];
$nasc = $_POST["nasc_log"];

$erro = "";

if(!$cpf){
	$erro = "cpf";
}elseif(!$nasc){
	$erro = "senha";
}


$criterio = new TCriteria;
$criterio->add(new TFilter('cpf', '=', "$cpf" ));
$criterio->add(new TFilter('dataNascimento', '=', "$nasc" ));
$repositorio = new TRepository("Pessoa");
$pessoas = $repositorio->load($criterio);
$pessoa = $pessoas[0]; // TODO - FIXME

// finaliza a transação
TTransaction::close();

if($pessoa->cpf AND $pessoa->dataNascimento AND $pessoa->cpf == $cpf AND $pessoa->dataNascimento == $nasc)
{
	
	$user = "$pessoa->id:$pessoa->cpf:$nasc";
	$cookie = base64_encode($user);
	// Acrescentar DATATIME de vencimento do cookie, se necessário!
	setcookie("mycv", $cookie);
	
	echo 'Redirecionando para área de edição.';
}else{
	$cpf = base64_encode($cpf);
	echo 'Não foi possível encontrar esse currículo. Confira seus dados e tente novamente.';
}

?>