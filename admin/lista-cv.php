<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

define("LISTA", true);

try
{
	
	// Recebe parâmetro de busca
	$nome = $_REQUEST[nome];
	$cpf = $_REQUEST[cpf];
	$expField = $_REQUEST[expField];
	$cursosField = $_REQUEST[cursosField];
	$estado = $_REQUEST[estado];
	$cidade = $_REQUEST[cidade];
	$bairro = $_REQUEST[bairro];
	$idade = $_REQUEST[idade];
	$sexo = $_REQUEST[sexo];
	$estadoCivil = $_REQUEST[estadoCivil];
	$habilitacao = $_REQUEST[habilitacao];
	$funcaoCargo = $_REQUEST[funcaoCargo];
	$salario = $_REQUEST[salario];
	$deficiencia = $_REQUEST[deficiencia];
	$experiencia = $_REQUEST[experiencia];
	$idadeInicio = $_REQUEST[deIdade];
	$idadeFim = $_REQUEST[ateIdade];
	$pagenum = $_REQUEST[pagenum];
	$more = "";
	
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-busca.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR CURRÍCULOS **");

	$criterio = new TCriteria;
	if($nome)
	{
		$criterio->add(new TFilter('pessoa.nome', 'LIKE', "%{$nome}%"));
		$more .= "nome=$nome&";
		$nomecheck = "<input type='checkbox' checked='checked' />";
	}else{
		$nomecheck="<input type='checkbox' />";
	}
	
	if($cpf)
	{
		$criterio->add(new TFilter('pessoa.cpf', 'LIKE', "%{$cpf}%" ));
		$more .= "cpf=$cpf&";
		$cpfcheck = "<input type='checkbox' checked='checked' />";
	}else{
		$cpfcheck="<input type='checkbox' />";
	}
	
	if($estado)
	{
		$criterio->add(new TFilter('pessoa.estado', 'LIKE', "%{$estado}%"));
		$more .= "estado=$estado&";
		$ufcheck = "<input type='checkbox' checked='checked' />";
	}else{
		$ufcheck="<input type='checkbox' />";
	}
	
	if($cidade)
	{
		$criterio->add(new TFilter('pessoa.cidade', 'LIKE', "%{$cidade}%"));
		$more .= "cidade=$cidade&";
		$cidadecheck = "<input type='checkbox' checked='checked' />";
	}else{
		$cidadecheck="<input type='checkbox' />";
	}
	
	if($idade)
	{
		$criterio->add(new TFilter('pessoa.idade', 'LIKE', "%{$idade}%"));
		$more .= "idade=$idade&";
		$idadecheck = "<input type='checkbox' checked='checked' />";
	}else{
		$idadecheck="<input type='checkbox' />";
	}
	
	if($bairro)
	{
		$criterio->add(new TFilter('pessoa.bairro', 'LIKE', "%{$bairro}%"));
		$more .= "bairro=$bairro&";
		$bairrocheck = "<input type='checkbox' checked='checked' />";
	}else{
		$bairrocheck="<input type='checkbox' />";
	}
	
	if($sexo)
	{
		$criterio->add(new TFilter('pessoa.sexo', 'LIKE', "%{$sexo}%"));
		$more .= "sexo=$sexo&";
		$sexocheck = "<input type='checkbox' checked='checked' />";
	}else{
		$sexocheck="<input type='checkbox' />";
	}
	
	if($estadoCivil)
	{
		$criterio->add(new TFilter('pessoa.estadoCivil', 'LIKE', "%{$estadoCivil}%"));
		$more .= "estadoCivil=$estadoCivil&";
		$estadoCivilcheck = "<input type='checkbox' checked='checked' />";
	}else{
		$estadoCivilcheck="<input type='checkbox' />";
	}
	
	if($habilitacao)
	{
		$criterio->add(new TFilter('pessoa.cnhTipo', 'LIKE', "%{$habilitacao}%"));
		$more .= "hbilitacao=$habilitacao&";
		$cnhcheck = "<input type='checkbox' checked='checked' />";
	}else{
		$cnhcheck="<input type='checkbox' />";
	}
	
	if($funcaoCargo)
	{
		$okz = true;
		if(!$more){$fecha = ")";}else{$fecha="";}
		$criterio->add(new TFilter('(pretensoes.primeiraFuncao', '=', "$funcaoCargo"), ") AND ");
		$criterio->add(new TFilter('pretensoes.segundaFuncao', '=', "$funcaoCargo"), "OR ");
		$criterio->add(new TFilter('pretensoes.terceiraFuncao', '=' ,"$funcaoCargo"), "OR ");
		$criterio->add(new TFilter('(pretensoes.idPessoa', '=' ,'pessoa.id'), ")$fecha AND ");
		$criterio->add(new TFilter('(escolaridade.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$criterio->add(new TFilter('(experiencia.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$more .= "funcaoCargo=$funcaoCargo&";
		$funcaocheck = "<input type='checkbox' checked='checked' />";
	}else{$funcaocheck="<input type='checkbox' />";}
	
	
	if($deficiencia)
	{
		$okz = true;
		$criterio->add(new TFilter('pretensoes.deficiencia', 'LIKE', "%{$deficiencia}%"));
		$criterio->add(new TFilter('(pretensoes.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$deficienciacheck = "<input type='checkbox' checked='checked' />";	
		$more .= "deficiencia=$deficiencia&";
	}else{$deficienciacheck="<input type='checkbox' />";}
	
	if($salario)
	{
		$okz = true;
		$criterio->add(new TFilter('pretensoes.salarioPretendido', 'LIKE', "%{$salario}%"));
		$criterio->add(new TFilter('(pretensoes.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$salariocheck = "<input type='checkbox' checked='checked' />";	
		$more .= "salario=$salario&";
	}else{$salariocheck="<input type='checkbox' />";}
	
	if($expField)
	{
		$okz = true;
		$criterio->add(new TFilter('experiencia.atividadesDesenvolvidas', 'LIKE', "%{$expField}%"));
		$criterio->add(new TFilter('(experiencia.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$criterio->add(new TFilter('(pretensoes.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$criterio->add(new TFilter('(escolaridade.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$expFcheck = "<input type='checkbox' checked='checked' />";	
		$more .= "expField=$expField&";
	}else{$expFcheck="<input type='checkbox' />";}
	
	if($cursosField)
	{
		$okz = true;
		$criterio->add(new TFilter('escolaridade.cursos', 'LIKE', "%{$cursosField}%"));
		$criterio->add(new TFilter('(escolaridade.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$criterio->add(new TFilter('(experiencia.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$criterio->add(new TFilter('(pretensoes.idPessoa', '=' ,'pessoa.id'), ") AND ");
		$cursoscheck = "<input type='checkbox' checked='checked' />";	
		$more .= "cursosField=$cursosField&";
	}else{$cursoscheck="<input type='checkbox' />";}
	
	
	if(!$okz)
	{
		$repositorio = new TRepository("Pessoa");
		$count = $repositorio->count($criterio);
	}else{
		$repositorio = new TRepository("PP");
		$count = $repositorio->count($criterio);		
	}
	
	if (!isset($pagenum))
	{ 
		$pagenum = 1; 
	}
	//This is the number of results displayed per page 
	$maxx = 20; 

	//This tells us the page number of our last page 
	$last = ceil($count/$maxx); 

	//this makes sure the page number isn't below one, or more than our maximum pages 
	if ($pagenum < 1){ 
		$pagenum = 1; 
	}elseif ($pagenum > $last AND $last != 0){ 
		$pagenum = $last; 
	} 

	//This sets the range to display in our query 
	$max = ($pagenum - 1) * $maxx .',' .$maxx;
	
	$criterio->setProperty("limit", "$max");
	
	$pessoas = $repositorio->load($criterio);

?>

<!--[if !IE]>start section<![endif]-->
<div class="section" id="muda" >
<div class="title_wrapper">
	<h2>Currículos: <?=$q?></h2>
	<a href="admin.php?op=lista" class="view_all_orders" title="Ver todos">Limpar busca</a>
</div>
<!--[if !IE]>start section inner<![endif]-->
<div class="section_inner">
	
	<!--[if !IE]>start table_wrapper<![endif]-->
	<div class="table_wrapper">
		
		<!--[if !IE]>start pagination<![endif]-->
		<div class="pagination">
			<?

			if($pagenum > 1){
				echo "<a href='admin.php?op=lista&pagenum=1&$more' class='buscar'>Primeira</a>";
				echo " ";
				$previous = $pagenum-1;
				echo " <a href='admin.php?op=lista&pagenum=$previous&$more' class='buscar'>Anterior</a> ";

			}
			
			for($x=1,$y=$last;$y>=1;$x++,$y--){
				if($pagenum == $x)
					echo " <span style='text-decoration:underline'>$x</span> ";
				else
					echo " <a href='admin.php?op=lista&pagenum=$x&$more' class='buscar'> $x </a> ";
			}

			 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
			 if ($pagenum != $last AND $last != 0){
			 $next = $pagenum+1;
			 echo " <a href='admin.php?op=lista&pagenum=$next&$more' class='buscar'>Próxima</a> ";
			 echo " ";
			 echo " <a href='admin.php?op=lista&pagenum=$last&$more' class='buscar'>Última</a> ";
			 }
			?>
		</div>
		<!--[if !IE]>end pagination<![endif]-->
		
		<div class="table_wrapper_inner">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr>
				<th width="7%" style="font-size:0.9em;">Atualização</th>
				<th width="12%" style="font-size:0.9em;">Status</th>
				<th width="20%" style="font-size:0.9em;">Nome Completo</th>
				<th width="15%" style="font-size:0.9em;">Bairro</th>
				<th width="7%" style="font-size:0.9em;">Salario</th>
				<th width="40%" style="font-size:0.9em;">Função Pretendida</th>
			</tr>	
			<?php
				$linha = "first";
				$i = false;
				if($pessoas)
				{
					foreach($pessoas as $pessoa)
					{
						if($pessoa->idPessoa)
							$idP=$pessoa->idPessoa;
						else
							$idP=$pessoa->id;
						if($more)
						{	
							$criterio = new TCriteria;
							$criterio->add(new TFilter('idPessoa', '=', $idP ));
							$criterio->setProperty("order", "id DESC");
							$criterio->setProperty("limit", "0,1");
							$repositorio = new TRepository("Atualizacao");
							$atualizacao = $repositorio->load($criterio);
							$atualizacao = $atualizacao[0];
					
							$criterio = new TCriteria;
							$criterio->add(new TFilter('idPessoa', '=', $idP ));
							$repositorio = new TRepository("Pretensoes");
							$pretensoes = $repositorio->load($criterio);
							$pretensao = $pretensoes[0];
						}else{
							$criterio = new TCriteria;
							$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
							$criterio->setProperty("order", "id DESC");
							$criterio->setProperty("limit", "0,1");
							$repositorio = new TRepository("Atualizacao");
							$atualizacaos = $repositorio->load($criterio);
							$atualizacao = $atualizacaos[0];
					
							$criterio = new TCriteria;
							$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
							$repositorio = new TRepository("Pretensoes");
							$pretensoes = $repositorio->load($criterio);
							$pretensao = $pretensoes[0];
						}
						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensao->primeiraFuncao ));
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$primeiraFuncao = $funcoes[0];

						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensao->segundaFuncao ));
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$segundaFuncao = $funcoes[0];

						$criterio = new TCriteria;
						$criterio->add(new TFilter('id', '=', $pretensao->terceiraFuncao ));
						$repositorio = new TRepository("Funcao");
						$funcoes = $repositorio->load($criterio);
						$terceiraFuncao = $funcoes[0];
						
						$funcaoPretensao = "";
						if($primeiraFuncao->Funcao)
						{
							$funcaoPretensao.=utf8_encode($primeiraFuncao->Funcao);
						}
						if($segundaFuncao->Funcao)
						{
							$funcaoPretensao.=', '.utf8_encode($segundaFuncao->Funcao);
						}
						if($terceiraFuncao->Funcao)
						{
							$funcaoPretensao.=', '.utf8_encode($terceiraFuncao->Funcao);
						}
						if(!$funcaoPretensao){$funcaoPretensao="Nenhuma Pretensão enviada";}
					
						if($i){$linha = "second";$i = false;}else{$linha = "first";$i++;}
						
						if($pessoa->ativo == "ativo"){$class = "approved";$tituloLink="Currículo ativo!";}else{$class = "pending";$tituloLink="Currículo desativado!";}
						if($pessoa->listaNegra){$onList = '<div class="ln" style="text-decoration:none;" title="Currículo na lista negra">&nbsp;</a>';}else{$onList="";}
						$nameP = ucwords(strtolower(htmlentities($pessoa->nome)));
						if($oldId != $idP)
						{
							echo '
								<tr class="'.$linha.'">
								<td width="7%">'.$atualizacao->dataTime.'</td>
								<td width="12%"><div id="'.$pessoa->idPessoa.'"  class="'.$class.'" style="text-decoration:none;" title="'.$tituloLink.'">&nbsp;</div> '.$onList.'</td>
								<td width="20%"><a href="admin.php?op=ver&cv='.$idP.'" title="Ver">'.substr($nameP, 0, 25).'...</a></td>
								<td width="15%" style="text-align:center">'.ucwords(strtolower(htmlentities($pessoa->bairro))).'</td>
								<td width="7%" style="text-align:center">'.$pretensao->salarioPretendido.'</td>
								<td width="40%">'.$funcaoPretensao.'</td>
								</tr>';
						}
						$oldId = $idP;
					}
				}else{
					echo '<tr colspan="6"><td colspan="6">Nenhum registro encontrado</td></tr>';
				}
			?>
			</tbody></table>
			</div>
			
			<!--[if !IE]>start pagination<![endif]-->
			<div class="pagination">
				<?

				if($pagenum > 1)
				{
					echo "<a href='admin.php?op=lista&pagenum=1&$more' class='buscar'>Primeira</a>";
					echo " ";
					$previous = $pagenum-1;
					echo " <a href='admin.php?op=lista&pagenum=$previous&$more' class='buscar'>Anterior</a> ";

				}

				for($x=1,$y=$last;$y>=1;$x++,$y--)
				{
					if($pagenum == $x)
						echo " <span style='text-decoration:underline'>$x</span> ";
					else
						echo " <a href='admin.php?op=lista&pagenum=$x&$more' class='buscar'> $x </a> ";
				}

				//This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
				if ($pagenum != $last AND $last != 0)
				{
					$next = $pagenum+1;
					echo " <a href='admin.php?op=lista&pagenum=$next&$more' class='buscar'>Próxima</a> ";
					echo " ";
					echo " <a href='admin.php?op=lista&pagenum=$last&$more' class='buscar'>Última</a> ";
				}
				?>
			</div>
			<!--[if !IE]>end pagination<![endif]-->
		</div>
		<!--[if !IE]>end table_wrapper<![endif]-->
		
		
	</div>
	<!--[if !IE]>end section inner<![endif]-->	
	
	
</div>
<!--[if !IE]>end section<![endif]-->


<?php
}
catch (Exception $e) // em caso de exceção
{
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}

?>
			
			
