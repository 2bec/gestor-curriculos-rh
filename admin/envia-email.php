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

if($_POST['id'])
{
	
	// inicia transa√ß√£o com o banco 'my_gcrh'
	TTransaction::open('my_gcrh');

	// define o arquivo para LOG
	TTransaction::setLogger(new TLoggerTXT('log-envios.txt'));

	// armazena esta frase no arquivo de LOG
	TTransaction::log("** LOG ENVIAR CURRICULO **");
	
	$pessoa = new Pessoa($_POST['id']);
	
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
	
	$texto     = "Olá,\n\nSegue um link para acesso ao currículo de $nameP ($idade anos):\n\n$link\n\nAtenciosamente,\nDinâmica Promoções & Marketing\n(41) 3079-8287\n(41) 3072-8250\nRua Marechal Deodoro, 255, 20 andar";

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