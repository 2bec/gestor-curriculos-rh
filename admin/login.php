<?php

/*
 * fun√ß√£o __autoload()
 * carrega uma classe quando ela √à necess√°ria,
 * ou seja, quando ela √© instancia pela primeira vez.
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

// inicia transa√ß√£o com o banco 'my_gcrh'
TTransaction::open('my_gcrh');

// define o arquivo para LOG
TTransaction::setLogger(new TLoggerTXT('log-login.txt'));

// armazena esta frase no arquivo de LOG
TTransaction::log("** LOGIN SISTEMA **");

$login = $_POST['login'];
$senha = $_POST["senha"];
$pass = sha1($senha);

$erro = "";

if(!$login)
{
	$erro = "login";
}elseif(!$senha){
	$erro = "senha";
}

if($erro)
{
	$login = base64_encode($login);
	header("Location: index.php?l=$login&erro=$erro");
	exit(-1);
}


$criterio = new TCriteria;
$criterio->add(new TFilter('login', '=', "$login" ));
$criterio->add(new TFilter('senha', '=', "$pass" ));
$repositorio = new TRepository("Usuario");
$usuario = $repositorio->load($criterio);
$usuario = $usuario[0];

// finaliza a transação
TTransaction::close();

if($usuario->login AND $usuario->senha AND $usuario->login == $login AND $usuario->senha == $pass)
{	
	$user = "$usuario->id:$usuario->login:$pass";
	$cookie = base64_encode($user);

	// Acrescentar DATATIME de vencimento do cookie, se necessário!
	setcookie("mygcrh", $cookie);
	
	header("Location: admin.php?op=lista");
}else{
	$login = base64_encode($login);
	header("Location: index.php?l=$login&erro=pass");
}

?>