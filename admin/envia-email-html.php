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

function calc_idade( $data_nasc ){
	$data_nasc = explode("/", $data_nasc);
	$data = date("d-m-Y");
	$data = explode("-", $data);
	$anos = $data[2] - $data_nasc[2];

	if ( $data_nasc[1] >= $data[1] )
	{
		if ( $data_nasc[0] <= $data[0] )
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

if($_POST['id']){
	
	// inicia transação com o banco 'my_gcrh'
	TTransaction::open('my_gcrh');

	// define o arquivo para LOG
	TTransaction::setLogger(new TLoggerTXT('log-envios.txt'));

	// armazena esta frase no arquivo de LOG
	TTransaction::log("** LOG ENVIAR CURRICULO **");
	
	$pessoa = new Pessoa($_POST['id']);
	
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('id', '=', $pessoa->cidade));
	$repositorio = new TRepository("Cidade");
	$cidades = $repositorio->load($criterio);
	$cidade = $cidades[0];
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
	
	$repositorio = new TRepository("Parecer");
	$parecer = $repositorio->load($criterio);
	$repositorio = new TRepository("Escolaridade");
	$escolaridade = $repositorio->load($criterio);
	$escolaridade = $escolaridade[0];
	
	$repositorio = new TRepository("Experiencia");
	$experiencias = $repositorio->load($criterio);
	
	$repositorio = new TRepository("Pretensoes");
	$pretensoes = $repositorio->load($criterio);
	$pretensoes = $pretensoes[0];
	
	$idade = calc_idade($pessoa->dataNascimento);
	
	$codigo = $_POST['email'].date('h:m:i').$pessoa->id;
	
	$envio = new Envios;
	$envio->cod = md5($codigo);
	$envio->cv = base64_encode($pessoa->id);
	$envio->store();
	
	
	$link = 'http://www.dinamicapromocoes.com.br/curriculos/ver-cv.php?cod='.$envio->cod.'';
	
	$headers   = "MIME-Version: 1.1\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "From: Dinâmica Promoções & Marketing <psicologia@dinamicapromocoes.com.br>\n"; // remetente
	$headers .= "Return-Path: Promoções & Marketing <psicologia@dinamicapromocoes.com.br>\n"; // return-path
	
	$nameP = ucwords(strtolower($pessoa->nome));
	
	$texto     = '
	<html lang="pt-BR"> 
	<head> 
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"> 
		<title>Currículo enviado pela Dinâmica Promoções & Marketing</title> 
		<style type="text/css"> 
			body, td{font-family:arial,sans-serif;font-size:80%} 
			a:link, a:active, a:visited{color:#0000CC} 
			img{border:0} 
			pre {white-space: pre; white-space: -moz-pre-wrap; white-space: -o-pre-wrap; white-space: pre-wrap; word-wrap: break-word; width: 800px; overflow: auto;}
		</style> 
	</head> 
	<body>
		<h2>Parecer</h2>
		<p>'.$parecer->texto.'</p>
		<h1>Currículo Dinâmica ('.$pessoa->id.')</h1> 
		<p>&nbsp;</p>
		<h2>Dados Pessoais</h2>
		<table border="0" cellpadding="0"> 
			<tbody> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Nome:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$pessoa->nome.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Sexo:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$pessoa->sexo.' </p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Estado Civil:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$pessoa->estadoCivil.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal"> </p></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Endereço:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$pessoa->endereco.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Habilitação:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Bairro:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$pessoa->bairro.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Idade:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">21</p></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Cidade:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$cidade->nome.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td>
			</tr> 
			<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">Estado:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
					<p class="MsoNormal">'.$cidade->uf.'</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td>
			</tr>
			</tbody>
		</table> 
		
		<h2>Escolaridade</h2> 
		<table border="0" cellpadding="0"> 
		<tbody> 
		<tr> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p class="MsoNormal">Nível:</p></td> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p class="MsoNormal">'.$escolaridade->nivel.'</p></td></tr> 
		<tr> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p class="MsoNormal">Formação:</p></td> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p style="margin-bottom:12pt" class="MsoNormal">'.$escolaridade->formacaoAcademica.'</p></td></tr> 
		<tr> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p class="MsoNormal">Cursos<span> de
		Aperfeiçoamento</span>:</p></td> 
		<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
		<p class="MsoNormal">'.$escolaridade->cursos.'</p></td></tr></tbody></table> 
		';
		
		$i = 0;
		foreach($experiencias as $experiencia)
		{
			if($i == 0) {$tit = "Último emprego";}
			elseif($i == 1) {$tit = "Penúltimo emprego";}
			elseif($i == 2) {$tit = "Antepenúltimo emprego";}
		
			$texto .= '<h2>'.$tit.'</h2> 
				<p>De '.$experiencia->dataAdmissao.' - '.$experiencia->dataDemissao.'</p> 
				<table border="0" cellpadding="0"> 
				<tbody> 
				<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">Nome:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" colspan="3"> 
				<p class="MsoNormal">'.$experiencia->empresa.'</p></td></tr> 
				<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">Ramo:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" colspan="3"> 
				<p class="MsoNormal">'.$experiencia->ramoAtividade.'</p></td></tr> 
				<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">Função:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">';

				$criterio = new TCriteria;
				$criterio->add(new TFilter('id', '=', $experiencia->funcaoCargo ));

				$repositorio = new TRepository("Funcao");
				$funcoes = $repositorio->load($criterio);
				$funcao = $funcoes[0];
				
				$texto .=''.$funcao->Funcao.'</p></td></tr>
				<tr>
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">Último Salário:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">'.$experiencia->salario.'</p></td></tr> 
				<tr> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class="MsoNormal">Atividade <span>Exercida</span>:</p></td> 
				<td style="padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" colspan="3"> 
				<p class="MsoNormal">'.$experiencia->atividadesDesenvolvidas.'</p></td></tr></tbody></table>';
			$i++;
		}
		
		$texto .= '<h2>Pretensões</h2> 
		<table border="0" cellpadding="0"> 
		<tbody> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">1ª Função:</p></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">';

				$criterio = new TCriteria;
				$criterio->add(new TFilter('id', '=', $pretensoes->primeiraFuncao ));

				$repositorio = new TRepository("Funcao");
				$funcoes = $repositorio->load($criterio);
				$funcao = $funcoes[0];
				
				$texto .=''.$funcao->Funcao.'</p></td>
		</tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">2ª Função:</p></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">';

				$criterio = new TCriteria;
				$criterio->add(new TFilter('id', '=', $pretensoes->segundaFuncao ));

				$repositorio = new TRepository("Funcao");
				$funcoes = $repositorio->load($criterio);
				$funcao = $funcoes[0];
				
				$texto .=''.$funcao->Funcao.'</p></td>
		</tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">3ª Função:</p></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">';

				$criterio = new TCriteria;
				$criterio->add(new TFilter('id', '=', $pretensoes->terceiraFuncao ));

				$repositorio = new TRepository("Funcao");
				$funcoes = $repositorio->load($criterio);
				$funcao = $funcoes[0];
				
				$texto .=''.$funcao->Funcao.'</p></td>
		</tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class  = "MsoNormal">Salário:</p></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class  = "MsoNormal">'.$pretensoes->salarioPretendido.'</p></td>
		</tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" valign="top"> 
				<p class  = "MsoNormal">Deficiencia:</p></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"> 
				<p class  = "MsoNormal">'.$pretensoes->deficiencia.'</p></td>
		</tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt" colspan="2"> 
				<p class  = "MsoNormal"> </p></td></tr> 
		<tr> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td> 
			<td style = "padding-bottom:1.5pt;padding-left:1.5pt;padding-right:1.5pt;padding-top:1.5pt"></td>
		</tr> 
		</tbody>
		</table> 
		
	</body>
	</html>';

	$envio     = mail("$_POST[email]", "Envio de currículo pela Dinâmica Promoções & Marketing", "$texto", $headers);
	
	// finaliza a transação
	TTransaction::close();

	if($envio)
		echo "Mensagem enviada com sucesso.";
	else
		echo "A mensagem não pode ser enviada.";
	
}else{
	echo "A mensagem não pode ser enviada.";
}
?>