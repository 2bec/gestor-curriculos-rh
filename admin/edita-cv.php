<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

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

try
{
    // inicia transa√ß√£o com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-edit.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG EDICAO DE CURRICULO **");
	
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

	$pessoa = new Pessoa($curriculoDados['idPessoa']);
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
	
	$escolaridade = new Escolaridade($curriculoDados['idEscolaridade']);
	$escolaridade->nivel = $curriculoDados['nivel'];
	$escolaridade->formacaoAcademica = $curriculoDados['formacaoAcademica'];
	$escolaridade->cursos = $curriculoDados['cursos'];
	$escolaridade->outros = $curriculoDados['outros'];
	$escolaridade->idPessoa = $pessoa->id;
	$escolaridade->store(); // armazena escolaridade
	
	$experiencia = new Experiencia($curriculoDados['idExperienciaPRI']);
	$experiencia->empresa = $curriculoDados['empresa'];
	$experiencia->ramoAtividade = $curriculoDados['ramoAtividade'];
	$experiencia->dataAdmissao = $curriculoDados['dataAdmissao'];
	$experiencia->dataDemissao = $curriculoDados['dataDemissao'];
	$experiencia->motivoSaida = $curriculoDados['motivoSaida'];
	$experiencia->salario = $curriculoDados['salario'];
	$experiencia->funcaoCargo = $curriculoDados['funcaoCargo'];
	$experiencia->atividadesDesenvolvidas = $curriculoDados['atividadesDesenvolvidas'];
	$experiencia->idPessoa = $pessoa->id;
	$experiencia->store(); // armazena experiencia
	
	$experiencia = new Experiencia($curriculoDados['idExperienciaPEN']);
	$experiencia->empresa = $curriculoDados['empresa'];
	$experiencia->ramoAtividade = $curriculoDados['ramoAtividade'];
	$experiencia->dataAdmissao = $curriculoDados['dataAdmissao'];
	$experiencia->dataDemissao = $curriculoDados['dataDemissao'];
	$experiencia->motivoSaida = $curriculoDados['motivoSaida'];
	$experiencia->salario = $curriculoDados['salario'];
	$experiencia->funcaoCargo = $curriculoDados['funcaoCargo'];
	$experiencia->atividadesDesenvolvidas = $curriculoDados['atividadesDesenvolvidas'];
	$experiencia->idPessoa = $pessoa->id;
	$experiencia->store(); // armazena experiencia
	
	$experiencia = new Experiencia($curriculoDados['idExperienciaANT']);
	$experiencia->empresa = $curriculoDados['empresa'];
	$experiencia->ramoAtividade = $curriculoDados['ramoAtividade'];
	$experiencia->dataAdmissao = $curriculoDados['dataAdmissao'];
	$experiencia->dataDemissao = $curriculoDados['dataDemissao'];
	$experiencia->motivoSaida = $curriculoDados['motivoSaida'];
	$experiencia->salario = $curriculoDados['salario'];
	$experiencia->funcaoCargo = $curriculoDados['funcaoCargo'];
	$experiencia->atividadesDesenvolvidas = $curriculoDados['atividadesDesenvolvidas'];
	$experiencia->idPessoa = $pessoa->id;
	$experiencia->store(); // armazena experiencia
	
	$pretensoes = new Pretensoes($curriculoDados['idPretensoes']);
	$pretensoes->primeiraFuncao = $curriculoDados['primeiraFuncao'];
	$pretensoes->segundaFuncao = $curriculoDados['segundaFuncao'];
	$pretensoes->terceiraFuncao = $curriculoDados['terceiraFuncao'];
	$pretensoes->salarioPretendido = $curriculoDados['salarioPretendido'];
	$pretensoes->horario = $curriculoDados['horario'];
	$pretensoes->deficiencia = $curriculoDados['deficiencia'];
	$pretensoes->idPessoa = $pessoa->id;
	$pretensoes->store(); // armazena pretensões
	
	$atualizacao = new Atualizacao;
	$atualizacao->id = "";
	$atualizacao->dataTime = date("d-m-Y");
	$atualizacao->idPessoa = $pessoa->id;
	$atualizacao->store();
	
	echo "$pessoa->id";
    // finaliza a transa√ß√£o
    TTransaction::close();
}
catch (Exception $e) // em caso de exce√ß√£o
{
    // exibe a mensagem gerada pela exce√ß√£o
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas altera√ß√µes no banco de dados
    TTransaction::rollback();
}
?>