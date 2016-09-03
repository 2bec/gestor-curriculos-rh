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
    TTransaction::log("** LOG UPLOAD DE CURRICULOS **");
	
	foreach($_POST as $key => $value)
	{
		$curriculoDados[$key] = utf8_decode($value);
		// GUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS
	}
	
	// TODO LIST:
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
	//$curriculo->fromArray($clienteDados);

	if(!$curriculoDados['id'])
	{
		$criterio = new TCriteria;
		$criterio->add(new TFilter('cpf', '=', $curriculoDados['cpf'] ));
		$repositorio = new TRepository("Pessoa");
		$pessoas = $repositorio->load($criterio);
		if(!$pessoas)
		{	
			$pessoa = new Pessoa;
			$pessoa->id = "";
			$pessoa->dataCadastro = date("d-m-Y");
			$pessoa->nome = $curriculoDados['nome'];
			$pessoa->cpf = $curriculoDados['cpf'];
			$pessoa->dataNascimento = $curriculoDados['dataNascimento'];
			if(!$curriculoDados['listaNegra']){$listaNegra = "Sem comentários";}else{$listaNegra = $curriculoDados['listaNegra'];}
			$pessoa->listaNegra = $listaNegra;
			$pessoa->store(); // armazena pessoa
		}else{
			$pessoa = $pessoas[0];
			// VERIFICAR COMO AGUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS	
			$cv = new Pessoa($pessoa['id']);
			if(!$curriculoDados['listaNegra']){$listaNegra = "Sem comentários";}else{$listaNegra = $curriculoDados['listaNegra'];}                                                 
			$cv->listaNegra = $listaNegra;
			$cv->store(); // armazena representante
		}
	}else{
		// VERIFICAR COMO AGUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS	
		$pessoa = new Pessoa($curriculoDados['id']);
		if(!$curriculoDados['listaNegra']){$listaNegra = "Sem comentários";}else{$listaNegra = $curriculoDados['listaNegra'];}                                                 
		$pessoa->listaNegra = $listaNegra;
		$pessoa->store(); // armazena representante
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