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
	

	$id = $_POST['id'];
	
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-delete.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG DELETE CURRICULO **");
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('id', '=', $id ));
	$repositorio = new TRepository("Pessoa");
	$repositorio->delete($criterio);
	
	echo "Registro excluído com sucesso !";
		
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