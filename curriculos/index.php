<?php


ini_set('default_charset','UTF-8'); // Para o charset das páginas e

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

function is_user($user) {
	
	// inicia transação com o banco 'my_gcrh'
	TTransaction::open('my_gcrh');

	// define o arquivo para LOG
	TTransaction::setLogger(new TLoggerTXT('log-verificacao.txt'));

	// armazena esta frase no arquivo de LOG
	TTransaction::log("** LOGIN CV **");
	
    if (!$user) { return 0; }
    if (!is_array($user))
    {
        $user = base64_decode($user);
        $user = addslashes($user);
        $user = explode(":", $user);
    	$uid = $user[0];
	    $nasc = $user[2];
	    $cpf = $user[1];
	    $uid = intval($uid);
	    if (!empty($uid) AND !empty($cpf))
	    {
			$criterio = new TCriteria;
			$criterio->add(new TFilter('cpf', '=', "$cpf" ));
			$criterio->add(new TFilter('dataNascimento', '=', "$nasc" ));
			$repositorio = new TRepository("Pessoa");
			$usuario = $repositorio->load($criterio);
			$usuario = $usuario[0];
			
			// finaliza a transação
			TTransaction::close();
			
	        if ($usuario->cpf == $cpf)
	        {
	            static $userSave;
	        	return $userSave = 1;
	        }
	    }	
    }	
	// finaliza a transação
	TTransaction::close();
    static $userSave;
    return $userSave = 0;
}

$op = $_REQUEST['op'];

$user = $_COOKIE["mycv"];

include("header.php");

if(!is_user($user))
{
	define("LOGIN", true);
	include("novo-cv.php");
}else{
	include("editar-cv.php");
}

include("sidebar.php");

include("footer.php");

?>
