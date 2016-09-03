<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e


/*
 * função __autoload()
 * carrega uma classe quando ela È necessária,
 * ou seja, quando ela é instancia pela primeira vez.
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

try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-edit.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG EDICAO DE USUARIO **");
	
	foreach($_POST as $key => $value)
	{
		$clienteDados[$key] = $value;
		// GUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS	
	}
	
	//TODO LIST: 
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
	//$cliente->fromArray($clienteDados);

	$usuario = new Usuario($clienteDados['user_id']);
	$usuario->login = $clienteDados['login'];
	if($clienteDados['email'])
		$usuario->email = base64_encode($clienteDados['email']);
	if($clienteDados['senha'])
		$usuario->senha = sha1($clienteDados['senha']);
	$usuario->permissao = $clienteDados['permissao'];
	$usuario->dataAtualizacao = date("d/m/Y");
	$usuario->store(); // armazena Usuario
	
    // finaliza a transação
    TTransaction::close();
}
catch (Exception $e) // em caso de exceção
{
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}
?>