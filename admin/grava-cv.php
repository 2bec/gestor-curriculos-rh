<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

// ADICIONAR HEADER UTF-8

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

try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-insert.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG CADASTRO DE CURRICULO **");
	
	foreach($_POST as $key => $value)
	{
		$curriculoDados[$key] = utf8_decode($value);
		// GUARDAR OS DADOS EM UFT-8 NO BANCO DE DADOS
	}
	
	// TODO LIST:
	// 1. INCLUIR CHECAGEM NOS CAMPOS $_POST
	// 2. EVITAR INJECTIONS
	// 3. CRIPTOGRAFAR DADOS SENSIVEIS	
	//$curriculo->fromArray($curriculoDados);

	$pessoa = new Pessoa;
	$pessoa->id = "";
	$pessoa->dataCadastro = date("d-m-Y");
	$pessoa->nome = $curriculoDados['nome'];
	$pessoa->cpf = $curriculoDados['cpf'];
	$pessoa->sexo = $curriculoDados['sexo'];
	$pessoa->dataNascimento = $curriculoDados['dataNascimento'];
	$pessoa->estadoCivil = $curriculoDados['estadoCivil'];
	$pessoa->cnh = $curriculoDados['cnh'];
	$pessoa->cnhTipo = $curriculoDados['cnhTipo'];
	$pessoa->cnhDataEmissao = $curriculoDados['cnhDataEmissao'];
	$pessoa->cnhDataValidade = $curriculoDados['cnhDataValidade'];
	$pessoa->rg = $curriculoDados['rg'];
	$pessoa->rgCidade = $curriculoDados['rgCidade'];
	$pessoa->rgDataEmissao = $curriculoDados['rgDataEmissao'];
	$pessoa->endereco = $curriculoDados['endereco'];
	$pessoa->bairro = $curriculoDados['bairro'];
	$pessoa->estado = $curriculoDados['estado'];
	$pessoa->cidade = $curriculoDados['cidade'];
	$pessoa->foneResidencial = $curriculoDados['foneResidencial'];
	$pessoa->foneCelular = $curriculoDados['foneCelular'];
	$pessoa->foneRecado = $curriculoDados['foneRecado'];
	$pessoa->falarCom = $curriculoDados['falarCom'];
	$pessoa->email = $curriculoDados['email'];
	$pessoa->store(); // armazena pessoa
	
	$escolaridade = new Escolaridade;
	$escolaridade->id = "";
	$escolaridade->nivel = $curriculoDados['nivel'];
	$escolaridade->formacaoAcademica = $curriculoDados['formacaoAcademica'];
	$escolaridade->cursos = $curriculoDados['cursos'];
	$escolaridade->outros = $curriculoDados['outros'];
	$escolaridade->idPessoa = $pessoa->id;
	$escolaridade->store(); // armazena escolaridade
	
	$experiencia = new Experiencia;
	$experiencia->id = "";
	$experiencia->empresa = $curriculoDados['empresa'];
	$experiencia->ramoAtividade = $curriculoDados['ramoAtividade'];
	$experiencia->dataAdmissao = $curriculoDados['dataAdmissao'];
	$experiencia->dataDemissao = $curriculoDados['dataDemissao'];
	$experiencia->motivoSaida = $curriculoDados['motivoSaida'];
	$experiencia->salario = $curriculoDados['salario'];
	$experiencia->funcaoCargo = $curriculoDados['funcaoCargo'];
	$experiencia->atividadesDesenvolvidas = $curriculoDados['atividadesDesenvolvidas'];
	$experiencia->idPessoa = $pessoa->id;
	$experiencia->tipo = "PRI";
	$experiencia->store(); // armazena experiencia
	
	$experiencia2 = new Experiencia;
	$experiencia2->id = "";
	$experiencia2->empresa = $curriculoDados['PEempresa'];
	$experiencia2->ramoAtividade = $curriculoDados['PEramoAtividade'];
	$experiencia2->dataAdmissao = $curriculoDados['PEdataAdmissao'];
	$experiencia2->dataDemissao = $curriculoDados['PEdataDemissao'];
	$experiencia2->motivoSaida = $curriculoDados['PEmotivoSaida'];
	$experiencia2->salario = $curriculoDados['PEsalario'];
	$experiencia2->funcaoCargo = $curriculoDados['PEfuncaoCargo'];
	$experiencia2->atividadesDesenvolvidas = $curriculoDados['PEatividadesDesenvolvidas'];
	$experiencia2->idPessoa = $pessoa->id;
	$experiencia2->tipo = "PEN";
	$experiencia2->store(); // armazena experiencia
	
	$experiencia3 = new Experiencia;
	$experiencia3->id = "";
	$experiencia3->empresa = $curriculoDados['ANempresa'];
	$experiencia3->ramoAtividade = $curriculoDados['ANramoAtividade'];
	$experiencia3->dataAdmissao = $curriculoDados['ANdataAdmissao'];
	$experiencia3->dataDemissao = $curriculoDados['ANdataDemissao'];
	$experiencia3->motivoSaida = $curriculoDados['ANmotivoSaida'];
	$experiencia3->salario = $curriculoDados['ANsalario'];
	$experiencia3->funcaoCargo = $curriculoDados['ANfuncaoCargo'];
	$experiencia3->atividadesDesenvolvidas = $curriculoDados['ANatividadesDesenvolvidas'];
	$experiencia3->idPessoa = $pessoa->id;
	$experiencia3->tipo = "ANT";
	$experiencia3->store(); // armazena experiencia
	
	$pretensoes = new Pretensoes;
	$pretensoes->id = "";
	$pretensoes->primeiraFuncao = $curriculoDados['primeiraFuncao'];
	$pretensoes->segundaFuncao = $curriculoDados['segundaFuncao'];
	$pretensoes->terceiraFuncao = $curriculoDados['terceiraFuncao'];
	$pretensoes->salarioPretendido = $curriculoDados['salarioPretendido'];
	$pretensoes->horario = $curriculoDados['horario'];
	$pretensoes->deficiencia = $curriculoDados['deficiencia'];
	$pretensoes->idPessoa = $pessoa->id;
	$pretensoes->store(); // armazena pretensões
	
	echo "$pessoa->id";
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