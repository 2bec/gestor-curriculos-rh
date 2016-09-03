<?php

define("Curriculo", true);

try
{
    // inicia transa√ß√£o com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-edit.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG EDITAR CURRICULO **");
	
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
	if($pessoa->ativo == "ativo")
	{
		$class = "approved";
		$image = "ativo";
		$tituloLink="Desativar";
		$tituloTexto="Ativo";
	}else{
		$class = "pending";
		$image = "desativado";
		$tituloLink="Ativar";
		$tituloTexto="Desativado";
	}
?>

<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Currículo: <?=$pessoa->nome?></h2>
		<div style="float:left;text-align:right;width:100%;height;1px;margin:0;padding:0">
			
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:76px;background:url(images/email.png) 3px no-repeat"><a href="admin.php?op=enviar-email&id=<?=$pessoa->id?>" title="Enviar por Email" id="enviar">Enviar</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:76px;background:url(images/imprimir.png) 3px no-repeat"><a href="imprimir.php?cv=<?=$pessoa->id?>" target="_blank" title="Imprimir">Imprimir</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:94px;background:url(images/<?=$image?>.png) 3px no-repeat"><a href="#"  class="<?=$class?>" name="vendo" id="<?=$pessoa->id?>"  style="padding:0px;background:none;margin:0" title="<?=$tituloLink?>"><?=$tituloTexto?></a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/editar.png) 3px no-repeat"><a href="admin.php?op=editar&cv=<?=$pessoa->id?>" title="Editar currículo">Editar</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/apagar.png) 3px no-repeat"><a href="admin.php?op=apagar&cv=<?=$pessoa->id?>" title="Excluir Currículo" class="delete" id="<?=$pessoa->id?>">Excluir</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:150px;background:url(images/bomba.png) 3px no-repeat"><a href="admin.php?op=add-lista&id=<?=$pessoa->id?>" title="Incluir na lista negra Currículo" id="<?=$pessoa->id?>">Incluir na lista negra</a></div>
			
		</div>
		
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">		
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/voltar.png) 3px no-repeat"><a href="javascript:history.go(-1)" style="padding-left:20px" title="Voltar a página anterior">Voltar</a></div>
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset class="seeU">
				<legend>Dados Pessoais</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Nome:</label>
						<h1 style="display:inline;margin:0;padding:0"><?=htmlentities($pessoa->nome)?></h1>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>CPF:</label> <?=$pessoa->cpf?>
					<label>RG:</label> <?=$pessoa->rg?>
					<label> CNH:</label> <?=$pessoa->cnh?>
					<label> CNH TIPO:</label> <?=$pessoa->cnhTipo?>
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
					foreach($experiencias as $experiencia)
					{
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
						<?=htmlentities($funcao->Funcao)?>
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
						<?=htmlentities($funcao->Funcao)?>
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
						<?=htmlentities($funcao->Funcao)?>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Salário Pretendido:</label> <?=htmlentities($pretensoes->salarioPretendido)?>
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


</div>
<!--[if !IE]>end section<![endif]-->

<?php
}
catch (Exception $e) // em caso de exce√ß√£o
{
    // exibe a mensagem gerada pela exce√ß√£o
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas altera√ß√µes no banco de dados
    TTransaction::rollback();
}

?>


