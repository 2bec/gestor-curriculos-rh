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
	// Recebe parâmetro de busca (query, q)
	$q = $_REQUEST['busca'];
	
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR CIDADES **");

	$criterio = new TCriteria;
	$criterio->add(new TFilter('uf', '=', $q ));
	$repositorio = new TRepository("Cidade");
	$cidades = $repositorio->load($criterio);

	if($cidades)
    {
		$options = "";
		foreach($cidades as $cidade)
        {
			$options .= '<option value="'.$cidade->id.'">'.htmlentities($cidade->nome).'</option>';
		}
		echo $options;
	}else{
		echo 'Nenhuma cidade encontrada!';
	}
	
}
catch (Exception $e) // em caso de exceção
{
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}

?>