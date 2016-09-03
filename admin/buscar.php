<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

define("LISTA", true);

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
	// Recebe parâmetro de busca
	$nome = $_POST[nome];
	$cpf = $_POST[cpf];
	$estado = $_POST[estado];
	$cidade = $_POST[cidade];
	$bairro = $_POST[bairro];
	$idade = $_POST[idade];
	$sexo = $_POST[sexo];
	$estadoCivil = $_POST[estadoCivil];
	$habilitacao = $_POST[habilitacao];
	$funcaoCargo = $_POST[funcaoCargo];
	$experiencia = $_POST[experiencia];
	$idadeInicio = $_POST[deIdade];
	$idadeFim = $_POST[ateIdade];
	$pagenum = $_POST[pagenum];

    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR CURRÍCULOS **");

	$criterio = new TCriteria;
	if($nome)	$criterio->add(new TFilter('nome', 'LIKE', "%{$nome}%" ));
	if($cpf)	$criterio->add(new TFilter('cpf', 'LIKE', "%{$cpf}%" ));
	if($estado)	$criterio->add(new TFilter('estado', 'LIKE', "%{$estado}%" ));	
	if($cidade)	$criterio->add(new TFilter('cidade', 'LIKE', "%{$cidade}%" ));
	if($bairro)	$criterio->add(new TFilter('bairro', 'LIKE', "%{$bairro}%" ));
	if($sexo) $criterio->add(new TFilter('sexo', 'LIKE', "%{$sexo}%"));
	if($estadoCivil) $criterio->add(new TFilter('estadoCivil', 'LIKE', "%{$estadoCivil}%" ));
	if($habilitacao) $criterio->add(new TFilter('cnhTipo', 'LIKE', "%{$habilitacao}%"));
	
	
	if ($funcaoCargo)
	{
		$criterioCargo = new TCriteria;
		$criterioCargo->add(new TFilter('primeiraFuncao', '=', "$funcaoCargo"), "OR ");
		$criterioCargo->add(new TFilter('segundaFuncao', '=', "$funcaoCargo"), "OR ");
		$criterioCargo->add(new TFilter('terceiraFuncao', '=' ,"$funcaoCargo"), "OR ");
		$repositorioCargo = new TRepository("Pretensoes");
		
		$pessoasCargo = $repositorioCargo->load($criterioCargo);
		
		if($pessoasCargo)
		{
			foreach($pessoasCargo as $pessoa)
			{
				$criterio->add(new TFilter('id', '=', "$pessoa->idPessoa"));
			}
		}else{
			echo "<p style='padding:10px;color:#f00'>* Critério de filtro <strong>Função / Cargo</strong> está sendo ignorado pois não retornou nenhum registro.</p>";
		}
	} 
	
	$repositorio = new TRepository("Pessoa");
	$count = $repositorio->count($criterio);
	
	 if (!(isset($pagenum)))
	 { 
	 	$pagenum = 1; 
	 }
	
	 //This is the number of results displayed per page 
	 $maxx = 20; 

	 //This tells us the page number of our last page 
	 $last = ceil($count/$maxx); 

	 //this makes sure the page number isn't below one, or more than our maximum pages 
	 if ($pagenum < 1)
	 { 
	 	$pagenum = 1; 
	 }elseif ($pagenum > $last){ 
	 	$pagenum = $last; 
	 } 

	 //This sets the range to display in our query 
	 $max = ($pagenum - 1) * $maxx .',' .$maxx;
	
	$criterio->setProperty("limit", "$max");
	
	$pessoas = $repositorio->load($criterio);

	

?>

<!--[if !IE]>start section inner<![endif]-->
<div class="section_inner" id="muda" >

<div class="title_wrapper">
	<h2>Currículos: <?=$q?></h2>
	<a href="admin.php?op=lista" class="view_all_orders" title="Ver todos">Limpar busca</a>
</div>
<!--[if !IE]>start section inner<![endif]-->
<div class="section_inner">

<!--[if !IE]>start table_wrapper<![endif]-->
<div class="table_wrapper" >

	
	<!--[if !IE]>start pagination<![endif]-->
	<div class="pagination">
		<?
		
		if($pagenum > 1)
		{
			echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=1'>Primeira</a>";
			echo " ";
			$previous = $pagenum-1;
			echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'>Anterior</a> ";
			
		}
		
		for($x=1,$y=$last;$y>=1;$x++,$y--)
		{
			if($pagenum == $x)
				echo " <span style='text-decoration:underline'>$x</span> ";
			else
				echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$x'> $x </a> ";
		}
		
		 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
		 if ($pagenum != $last){
		 $next = $pagenum+1;
		 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Próxima </a> ";
		 echo " ";
		 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Última </a> ";
		 }
		?>
	</div>
	<!--[if !IE]>end pagination<![endif]-->
	
	<div class="table_wrapper_inner">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr>
				<th width="2%" style="font-size:0.9em;">Id.</th>
				<th width="15%" style="font-size:0.9em;"><a href="#">Status</a></th>
				<th width="30%" style="font-size:0.9em;"><a href="#" class="desc">Nome Completo</a></th>
				<th width="8%" style="font-size:0.9em;"><a href="#">Atualizado</a></th>
				<th width="37%" style="font-size:0.9em;"><a href="#">Função Pretendida</a></th>
				<th width="8%" style="font-size:0.9em;">Ações</th>
			</tr>	
			<?php
				$linha = "first";
				$i = false;
				$t = 0;
				if($pessoas)
				{
					foreach($pessoas as $pessoa)
					{
						$criterio = new TCriteria;
						$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
						$repositorio = new TRepository("Atualizacao");
						$atualizacao = $repositorio->load($criterio);
						$atualizacao = $atualizacao[0];
					
						$repositorio = new TRepository("Pretensoes");
						$pretensoes = $repositorio->load($criterio);
						$pretensao = $pretensoes[0];
						
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
						
						if($i){$linha = "second";$i = false;}else{$linha = "first";$i++;}
						
						if($pessoa->ativo == "ativo")
						{
							$class = "approved";
							$tituloLink="Desativar";
						}else{
							$class = "pending";
							$tituloLink="Ativar";
						}
						
						echo '
						<tr class="'.$linha.'">
							<td width="2%">'.$pessoa->id.'</td>
							<td width="15%"><a href=""  class="ativo '.$class.'" style="text-decoration:none;" title="'.$tituloLink.'">'.$pessoa->ativo.'</a></td>
							<td width="20%">'.$pessoa->nome.'</td>
							<td width="8%" style="text-align:center">'.$atualizacao->dataTime.'</td>
							<td width="37%">'.substr($primeiraFuncao->Funcao, 0, 8).', '.substr($segundaFuncao->Funcao, 0, 8).', '.substr($terceiraFuncao->Funcao, 0, 8).'</td>
							<td width="18%">
								<div class="actions">
									<ul>
										<li><a class="verIco" href="admin.php?op=ver&cv='.$pessoa->id.'" title="Ver">ver</a></li>
										<li><a class="editarIco" href="admin.php?op=editar&cv='.$pessoa->id.'" title="Editar">editar</a></li>
										<li><a href="imprimir.php?cv='.$pessoa->id.'" target="_blank" class="imprimirIco" title="Imprimir">imprimir</a></li>
									</ul>
								</div>
							</td>
						</tr>';
						$t++;
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
					echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=1'>Primeira</a>";
					echo " ";
					$previous = $pagenum-1;
					echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'>Anterior</a> ";

				}

				for($x=1,$y=$last;$y>=1;$x++,$y--)
				{
					if($pagenum == $x)
						echo " <span style='text-decoration:underline'>$x</span> ";
					else
						echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$x'> $x </a> ";
				}

				 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
				 if ($pagenum != $last)
				 {
					$next = $pagenum+1;
					echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Próxima</a> ";
					echo " ";
					echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Última</a> ";
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
			
			
