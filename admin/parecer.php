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
    TTransaction::log("** LOG INSERT PARECER **");
	
	foreach($_POST as $key => $value)
	{
		$curriculoDados[$key] = $value;
	}
	
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
		//$curriculo->fromArray($clienteDados);
	if($curriculoDados['op'] == "edit")
	{
		$criterio = new TCriteria;
		$criterio->add(new TFilter('idPessoa', '=', $curriculoDados['id'] ));
		$repositorio = new TRepository("Parecer");
		$parecer = $repositorio->load($criterio);
		$parecer = $parecer[0];
		$parecer->dataParecer = date("d-m-Y");
		$parecer->texto = $curriculoDados['parecerTxt'];
		$parecer->store(); // armazena representante
	}else{
		// VERIFICAR COMO AGUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS	
		$parecer = new Parecer();
		$parecer->id = "";
		$parecer->idPessoa = $curriculoDados['id'];
		$parecer->dataParecer = date("d-m-Y");
		$parecer->texto = $curriculoDados['parecerTxt'];
		$parecer->store(); // armazena representante
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