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
	TTransaction::log("** LOGIN VERIFICACAO **");
	
    if (!$user) { return 0; }
    if (!is_array($user))
    {
        $user = base64_decode($user);
        $user = addslashes($user);
        $user = explode(":", $user);
    	$uid = $user[0];
	    $pwd = $user[2];
	    $uid = intval($uid);
	    if (!empty($uid) AND !empty($pwd))
	    {
			$criterio = new TCriteria;
			$criterio->add(new TFilter('id', '=', "$uid" ));
			$repositorio = new TRepository("Usuario");
			$usuario = $repositorio->load($criterio);
			$usuario = $usuario[0];
			
			// finaliza a transação
			TTransaction::close();
			
	        if ($usuario->senha == $pwd)
	        {
	            static $userSave;
	        	return $userSave = 1;
	        }
	    }	
    }
    static $userSave;
    return $userSave = 0;
}

function calc_idade( $data_nasc )
{
	$data_nasc = explode("/", $data_nasc);
	$data = date("d-m-Y");
	$data = explode("-", $data);
	$anos = $data[2] - $data_nasc[2];

	if ($data_nasc[1] >= $data[1]){
		if ($data_nasc[0] <= $data[0]){
			return $anos; break;
		}else{
			return $anos-1;
			break;
		}
	}else{
		return $anos;
	}
}

$user = $_COOKIE["dinamica"];

if(!is_user($user))
{
	header("Location: index.php");
	die();
}


// inicia transação com o banco 'my_gcrh'
TTransaction::open('my_gcrh');

// define o arquivo para LOG
TTransaction::setLogger(new TLoggerTXT('log-imprimir.txt'));

// armazena esta frase no arquivo de LOG
TTransaction::log("** LOGIN IMPRIMIR **");

$id = $_GET['cv'];
$pessoa = new Pessoa($id);

$criterio = new TCriteria;
$criterio->add(new TFilter('id', '=', $pessoa->cidade));
$repositorio = new TRepository("Cidade");
$cidades = $repositorio->load($criterio);
$cidade = $cidades[0];

$criterio = new TCriteria;
$criterio->add(new TFilter('idPessoa', '=', "$pessoa->id" ));

$repositorio = new TRepository("Escolaridade");
$escolaridade = $repositorio->load($criterio);
$escolaridade = $escolaridade[0];

$criterio = new TCriteria;
$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
$repositorio = new TRepository("Experiencia");
$experiencias = $repositorio->load($criterio);

$criterio = new TCriteria;
$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
$repositorio = new TRepository("Pretensoes");
$pretensoes = $repositorio->load($criterio);
$pretensoes = $pretensoes[0];

$criterio = new TCriteria;
$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
$criterio->setProperty("order", "dataTime ASC");
$repositorio = new TRepository("Atualizacao");
$atualizacao = $repositorio->load($criterio);
$atualizacao = $atualizacao[0];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GCRH - Imprimir Currículo</title>

<script type="text/javascript" src="js/jquery.js"></script>

<style type="text/css">
	div {font-size:12px;}
    legend { font-size:16px; margin:0px; padding:5px 0px; color:#FF7815; font-weight:bold;}
	.seeU{border:0;}
</style>

<script type="text/javascript">
    $(document).ready(function(){
		window.print();
	});
</script>
</head>
<body>
	<div style="background-color:#222;width:98%;padding:10px;margin-bottom:15px"><img src="images/logo.png" width="193" height="43" alt="Logo"></div>
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">		
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Dados Pessoais</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Nome:</label>
						<h2 style="display:inline;margin:0;padding:0"><?=ucwords(strtolower(htmlentities($pessoa->nome)))?></h2>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>CPF:</label> <?=$pessoa->cpf?>
					<label>RG:</label> <?=$pessoa->rg?>
					<label> CNH:</label> <?=$pessoa->cnh?>
				</div>
				<!--[if !IE]>end row<![endif]-->				
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Data nascimento:</label> <? echo "$pessoa->dataNascimento"; $anos = calc_idade($pessoa->dataNascimento); echo " ( $anos anos )";?>
					<label> Sexo:</label> <?=$pessoa->sexo?>
					<label> Estado civil:</label> <?=$pessoa->estadoCivil?>
				</div>
				<!--[if !IE]>end row<![endif]-->		
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Endereço:</label> <?=htmlentities($pessoa->endereco)?>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Bairro:</label> <?=htmlentities($pessoa->bairro)?>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Cidade:</label> <?=$cidade->nome?>
					<label> Estado:</label> <?=$pessoa->estado?>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Fone Resid.:</label> <?=$pessoa->foneResidencial?>
					<label>Fone Celular:</label> <?=$pessoa->foneCelular?>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Fone Contato:</label> <?=$pessoa->foneRecado?> <?=htmlentities($pessoa->falarCom)?>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Email:</label> <?=$pessoa->email?>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Educação</legend>			
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Escolaridade:</label> <?=$escolaridade->nivel?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Formação Acadêmica:</label> <?=htmlentities($escolaridade->formacaoAcademica)?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Cursos de Idiomas / Cursos Técnicos:</label> <?=htmlentities($escolaridade->cursos)?>
					</div>
					<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Experiência Profissional</legend>
					<?php
					$i = 0;
					foreach($experiencias as $experiencia){
						if($i == 0) {echo "<h1 style='font-size:1.2em'>Último emprego</h1>";}
						elseif($i == 1) {echo "<h1 style='font-size:1.2em'>Penúltimo emprego</h1>";}
						elseif($i == 2) {echo "<h1 style='font-size:1.2em'>Antepenúltimo emprego</h1>";}
					?>
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Empresa:</label> <?=htmlentities($experiencia->empresa)?>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Ramo / Atividade:</label> <?=htmlentities($experiencia->ramoAtividade)?>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<div class="inputs">
								<label>data admissão: </label> <?=$experiencia->dataAdmissao?>
								<label>data demissão: </label> <?=$experiencia->dataDemissao?>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Motivo de saída:</label> <?=htmlentities($experiencia->motivoSaida)?>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Salário:</label> <?=htmlentities($experiencia->salario)?>
						</div>
						<!--[if !IE]>end row<![endif]-->
						
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Função / Cargo:</label> 
							<?
							$criterio = new TCriteria;
							$criterio->add(new TFilter('id', '=', $experiencia->funcaoCargo ));

							$repositorio = new TRepository("Funcao");
							$funcoes = $repositorio->load($criterio);
							$funcao = $funcoes[0];

							?>
							<?=htmlentities($funcao->Funcao)?>
						</div>
						<!--[if !IE]>end row<![endif]-->
						
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Atividades Desenvolvidas:</label> <?=htmlentities($experiencia->atividadesDesenvolvidas)?>
						</div>
						<!--[if !IE]>end row<![endif]-->
					<?php
						++$i;
					}
					
					?>
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			
			
</div>
<!--[if !IE]>end section inner<![endif]-->
</body>
</html>