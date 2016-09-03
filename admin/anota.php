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
    TTransaction::setLogger(new TLoggerTXT('log-edita.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG INSERT ANOTACOES **");
	
	foreach($_POST as $key => $value)
	{
		$curriculoDados[$key] = $value;
		// AGUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS
	}
	
	// TODO LIST:
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
	//$curriculo->fromArray($clienteDados);

	if($curriculoDados['op'] == "edit")
	{		
		$criterio = new TCriteria;
		$criterio->add(new TFilter('idPessoa', '=', $curriculoDados['id'] ));
		$repositorio = new TRepository("Anotacao");
		$anotacoes = $repositorio->load($criterio);
		$anotacao = $anotacoes[0];
		
		$anotacao->dataAnotacao = date("d-m-Y");
		$anotacao->texto = $curriculoDados['anotaTxt'];
		$anotacao->store(); // armazena representante
	}else{
		// Banco em utf-8, conexão em utf-8, headers em utf-8
		$anotacao = new Anotacao();
		$anotacao->id = "";
		$anotacao->idPessoa = $curriculoDados['id'];
		$anotacao->dataAnotacao = date("d-m-Y");
		$anotacao->texto = $curriculoDados['anotaTxt'];
		$anotacao->store(); // armazena representante
	}
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