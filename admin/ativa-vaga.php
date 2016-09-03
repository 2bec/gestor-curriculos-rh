<?php

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
    TTransaction::log("** LOG UPLOAD DE VAGAS **");
	
	foreach($_POST as $key => $value)
    {
		$curriculoDados[$key] = $value;
	}
	
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
		//$curriculo->fromArray($clienteDados);
		
	// VERIFICAR COMO AGUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS	
	$vaga = new Vaga($curriculoDados['id']);
	if($curriculoDados['op'] == "ativa")
    {
		$vaga->ativo = "s";
	}elseif($curriculoDados['op'] == "desativa"){
		$vaga->ativo = "n";
	}
	$vaga->store(); // armazena representante
	
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