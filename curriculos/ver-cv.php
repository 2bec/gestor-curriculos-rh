<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

/*
 * função __autoload()
 * carrega uma classe quando ela é necessáia,
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

function is_user($cod)
{
	
	// inicia transação com o banco 'my_gcrh'
	TTransaction::open('my_gcrh');

	// define o arquivo para LOG
	TTransaction::setLogger(new TLoggerTXT('log-verificacao.txt'));

	// armazena esta frase no arquivo de LOG
	TTransaction::log("** LOGIN VERIFICACAO **");
	
    if (!$cod) { return 0; }
    if (!is_array($cod))
    {
			$criterio = new TCriteria;
			$criterio->add(new TFilter('cod', '=', "$cod" ));
			$repositorio = new TRepository("Envios");
			$cv = $repositorio->load($criterio);
			$cv = $cv[0];
			
			// finaliza a transação
			TTransaction::close();
			
	        if ($cv->cod == $cod)
	        {
	            static $userSave;
	        	return $userSave = 1;
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

	if($data_nasc[1] >= $data[1])
	{
		if($data_nasc[0] <= $data[0])
		{
			return $anos; break;
		}else{
			return $anos-1;
			break;
		}
	}else{
		return $anos;
	}
}

$cod = $_GET["cod"];

if(!is_user($cod))
{
	header("Location: index.php");
	die();
}

// inicia transação com o banco 'my_gcrh'
TTransaction::open('my_gcrh');

// define o arquivo para LOG
TTransaction::setLogger(new TLoggerTXT('log-visualizar.txt'));

// armazena esta frase no arquivo de LOG
TTransaction::log("** LOGIN VISUALIZAR POR ENVIO **");

$criterio = new TCriteria;
$criterio->add(new TFilter('cod', '=', "$cod" ));
$repositorio = new TRepository("Envios");
$cv = $repositorio->load($criterio);
$cv = $cv[0];
		
$id = base64_decode($cv->cv);
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>http://www.dinamica.com.br - Imprimir Currículo</title>

<script type="text/javascript" src="js/jquery.js"></script>

<style type="text/css">
	div {font-size:13px;}
    legend { font-size:18px; margin:0px; padding:10px 0px; color:#FF7815; font-weight:bold;}
</style>

</head>
<body>
	<div style="background-color:#222;width:98%;padding:10px;margin-bottom:20px"><img src="../img/logo-dinamica.png" width="193" height="43" alt="Logo"></div>
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">		
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Dados Pessoais</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Nome:</label>
						<h1 style="display:inline;margin:0;padding:0"><?=$pessoa->nome?></h1>
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
					<label> Endereço:</label> <?=$pessoa->endereco?>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Bairro:</label> <?=$pessoa->bairro?>
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
					<label>Fone Contato:</label> <?=$pessoa->foneRecado?> <?=$pessoa->falarCom?>
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
						<label>Formação Acadêmica:</label> <?=$escolaridade->formacaoAcademica?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Cursos de Idiomas / Cursos Técnicos:</label> <?=$escolaridade->cursos?>
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
							<label>Empresa:</label> <?=$experiencia->empresa?>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Ramo / Atividade:</label> <?=$experiencia->ramoAtividade?>
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
							<label>Motivo de saída:</label> <?=$experiencia->motivoSaida?>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Salário:</label> <?=$experiencia->salario?>
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
							<?=$funcao->Funcao?>
						</div>
						<!--[if !IE]>end row<![endif]-->
						
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Atividades Desenvolvidas:</label> <?=$experiencia->atividadesDesenvolvidas?>
						</div>
						<!--[if !IE]>end row<![endif]-->
					<?php
						++$i;
					}
					
					?>
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Pretensões</legend>
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 1:</label> 
						<?
						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensoes->primeiraFuncao ));
						
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$funcao = $funcoes[0];
						
						?>
						<?=$funcao->Funcao?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 2:</label> 
						<?
						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensoes->segundaFuncao ));
						
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$funcao = $funcoes[0];
						
						?>
						<?=$funcao->Funcao?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 3:</label> 
						<?
						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensoes->terceiraFuncao ));
						
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$funcao = $funcoes[0];
						
						?>
						<?=$funcao->Funcao?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Salário Pretendido:</label> <?=$pretensoes->salarioPretendido?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Disponibilidade para trabalhar em qualquer horário?</label> <?if($pretensoes->horario){echo "$pretensoes->horario";}else{echo "[Não preencheu]";}?>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Possui alguma deficiência?</label> <?if($pretensoes->deficiencia){echo "$pretensoes->deficiencia";}else{echo "[Não preencheu]";}?>
					</div>
					<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
</div>
<!--[if !IE]>end section inner<![endif]-->
</body>
</html>