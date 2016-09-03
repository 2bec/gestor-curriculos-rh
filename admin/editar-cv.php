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
	$criterio->add(new TFilter('idPessoa', '=', "$pessoa->id" ));

	$repositorio = new TRepository("Escolaridade");
	$escolaridade = $repositorio->load($criterio);
	$escolaridade = $escolaridade[0];
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
	$criterio->add(new TFilter('tipo', '=', 'PRI' ));

	$repositorio = new TRepository("Experiencia");
	$exp_pri = $repositorio->load($criterio);
	$exp_pri = $exp_pri[0];
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
	$criterio->add(new TFilter('tipo', '=', 'PEN' ));

	$repositorio = new TRepository("Experiencia");
	$exp_pen = $repositorio->load($criterio);
	$exp_pen = $exp_pen[0];
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
	$criterio->add(new TFilter('tipo', '=', 'ANT' ));

	$repositorio = new TRepository("Experiencia");
	$exp_ant = $repositorio->load($criterio);
	$exp_ant = $exp_ant[0];
	
	$criterio = new TCriteria;
	$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));

	$repositorio = new TRepository("Pretensoes");
	$pretensoes = $repositorio->load($criterio);
	$pretensoes = $pretensoes[0];
	if($pessoa->ativo == "ativo"){$class = "approved";$image = "ativo";$tituloLink="Desativar";$tituloTexto="Ativo";}else{$class = "pending";$image = "desativado";$tituloLink="Ativar";$tituloTexto="Desativado";}
?>

<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Currículo: <?=$pessoa->nome?></h2>
		<div style="float:left;text-align:right;width:100%;height;1px;margin:0;padding:0">
		<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:76px;background:url(images/imprimir.png) 3px no-repeat"><a href="imprimir.php?cv=<?=$pessoa->id?>" target="_blank" title="Imprimir">Imprimir</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/salvar.png) 3px no-repeat"><a href="#" title="Salvar alterações">Salvar</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:94px;background:url(images/<?=$image?>.png) 3px no-repeat"><a href="#" id="<?=$pessoa->id?>" class="<?=$class?>" name="editando" style="padding:0px;margin:0;background:none" title="<?=$tituloLink?>"><?=$tituloTexto?></a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:150px;background:url(images/bomba.png) 3px no-repeat"><a href="admin.php?op=add-lista&id=<?=$pessoa->id?>" title="Incluir na lista negra Currículo" id="<?=$pessoa->id?>">Incluir na lista negra</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/apagar.png) 3px no-repeat"><a href="admin.php?op=apagar&cv=<?=$pessoa->id?>" title="Excluir Currículo" class="delete" id="<?=$pessoa->id?>">Excluir</a></div>
			<div style="border:1px solid #c2c2c2;padding:3px;margin:5px;float:right;width:60px;background:url(images/voltar.png) 3px no-repeat"><a href="javascript:history.go(-1)" title="Voltar a página anterior">Voltar</a></div>
		</div>
		
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">
	
	<!--[if !IE]>start forms<![endif]-->
	<form id="editaCv" action="edita-cv.php" class="search_form general_form" method="post">
		<input type="hidden" name="idPessoa" value="<?=$pessoa->id?>" />
		<input type="hidden" name="idEscolaridade" value="<?=$escolaridade->id?>" />
		<input type="hidden" name="idExperienciaPRI" value="<?=$exp_pri->id?>" />
		<input type="hidden" name="idExperienciaPEN" value="<?=$exp_pen->id?>" />
		<input type="hidden" name="idExperienciaANT" value="<?=$exp_ant->id?>" />
		<input type="hidden" name="idPretensoes" value="<?=$pretensoes->id?>" />
			<!--[if !IE]>start forms<![endif]-->
			<div class="forms_">		
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Dados Pessoais</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Nome:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text" name="nome" type="text" value="<?=htmlentities($pessoa->nome)?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> CPF:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text cpf" name="cpf" type="text" value="<?=$pessoa->cpf?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->				

				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>RG:</label><br />
					<div class="inputs">
						<span class="input_wrapper"><input class="text" name="rg" type="text" value="<?=$pessoa->rg?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Data nascimento:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text data" name="dataNascimento" type="text" value="<?=$pessoa->dataNascimento?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<?php
				
				if($pessoa->sexo == "Masculino") $masculino = "checked='checked'";
				else $feminino = "checked='checked'";
				
				if($pessoa->estadoCivil == "Solteiro")
				{
					$solteiro = "checked='checked'";
				}elseif($pessoa->estadoCivil == "Casado"){
					$casado = "checked='checked'";
				}elseif($pessoa->estadoCivil == "Divorciado"){
					$divorciado = "checked='checked'";
				}elseif($pessoa->estadoCivil == "Outro"){
					$outro = "checked='checked'";
				}
				
				?>
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Sexo:</label>
					<div class="inputs">
						<ul>
							<li><input id="masculino" class="radio" name="sexo" value="Masculino" type="radio" <?=$masculino?> /> <label class="normal" for="masculino">Masculino</label></li>
							<li><input id="feminino" class="radio" name="sexo" value="Feminino" type="radio" <?=$feminino?> /> <label class="normal" for="feminino">Feminino</label></li>
						</ul>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Estado civil:</label>
					<div class="inputs">
						<ul class="">
							<li> <input id="solteiro" class="radio" name="estadoCivil" value="Solteiro" type="radio" <?=$solteiro?> /> <label class="normal" for="solteiro"> Solteiro</label></li>
							<li> <input id="casado" class="radio" name="estadoCivil" value="Casado" type="radio" <?=$casado?>/> <label class="normal" for="casado"> Casado</label></li>
							<li> <input id="divorciado" class="radio" name="estadoCivil" value="Divorciado" type="radio" <?=$divorciado?> /> <label class="normal" for="divorciado"> Divorciado</label></li>
							<li> <input id="outro" class="radio" name="estadoCivil" value="Outro" type="radio" <?=$outro?> /> <label class="normal" for="outro"> Outro</label></li>
						</ul>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>CNH:</label>
					<div class="inputs">
						<span class="input_wrapper">Tipo cnh
							<select name="cnhTipo">
								<option value="-">Não tenho CNH</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="AB">AB</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
							</select>
						</span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Endereço:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text" name="endereco" type="text" value="<?=htmlentities($pessoa->endereco)?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Bairro:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text" name="bairro" type="text" value="<?=htmlentities($pessoa->bairro)?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Estado:</label>
					<div class="inputs">
						<ul>
							<li><span class="input_wrapper">
								<select name="estado" id="estado">
									<option value="">Selecione um estado</option>
									<?php
							
									$criterio = new TCriteria;
									$criterio->add(new TFilter('id', '>', '0' ));

									$repositorio = new TRepository("Estado");
									$estados = $repositorio->load($criterio);
									
									
									if($estados)
									{
										foreach($estados as $estado)
										{
											if($pessoa->estado == $estado->uf) $selected = "selected"; else $selected = "";
											echo '<option value="'.$estado->uf.'" '.$selected.'>'.htmlentities($estado->nome).'</option>';
										}
									}
									
									?>
							</select>
							</span> </li>
						</ul>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Cidade:</label>
					<div class="inputs">
						<span class="input_wrapper">
							<select name="cidade" id="cidade">
								<option value="">Selecione uma cidade</option>
									<?php

											$criterio = new TCriteria;
											$criterio->add(new TFilter('uf', '=', $pessoa->estado));

											$repositorio = new TRepository("Cidade");
											$cidades = $repositorio->load($criterio);


											if($cidades)
											{
												foreach($cidades as $cidade)
												{
													if($pessoa->cidade == $cidade->id) $selected = "selected"; else $selected = "";
													echo '<option value="'.$cidade->id.'" '.$selected.'>'.$cidade->nome.'</option>';
												}
											}
									?>
							</select>
						</span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label> Fone Resid.:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text fone" name="foneResidencial" type="text" value="<?=$pessoa->foneResidencial?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Fone Celular:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text fone" name="foneCelular" type="text" value="<?=$pessoa->foneCelular?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Fone Contato:</label>
					<div class="inputs">
						<span class="input_wrapper" style="text-align:center;font-size:.7em">Telefone Contato <input class="text fone required" name="foneRecado" type="text" value="<?=$pessoa->foneRecado?>" /></span>
						<span class="input_wrapper" style="text-align:center;font-size:.7em">Nome Contato <input class="text required" name="falarCom" type="text" value="<?=htmlentities($pessoa->falarCom)?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Email:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text" name="email" type="text" value="<?=$pessoa->email?>" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
				<?php
				
				if($escolaridade->nivel == "Primario (1º a 8º) Incompleto")
				{
					$primarioIncom = "selected='selected'";
				}elseif($escolaridade->nivel == "Primario (1º a 8º) Completo"){
					$primarioCompleto = "selected='selected'";
				}elseif($escolaridade->nivel == "Segundo grau Incompleto"){
					$SegundoIncom = "selected='selected'";
				}elseif($escolaridade->nivel == "Segundo grau Completo"){
					$segundoCompleto = "selected='selected'";
				}elseif($escolaridade->nivel == "Ensino tecnico Incompleto"){
					$tecnicoIncom = "selected='selected'";
				}elseif($escolaridade->nivel == "Ensino tecnico Completo"){
					$tecnicoCompleto = "selected='selected'";
				}elseif($escolaridade->nivel == "Ensino superior incompleto"){
					$superiorIncom = "selected='selected'";
				}elseif($escolaridade->nivel == "Ensino superior Completo"){
					$superiorCompleto = "selected='selected'";
				}elseif($escolaridade->nivel == "Pos graduado"){
					$pos = "selected='selected'";
				}elseif($escolaridade->nivel == "Mestrado"){
					$mestrado = "selected='selected";
				}
				
				?>
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Educação</legend>
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Escolaridade:</label>
						<div class="inputs">
							<select name="nivel">
								<option value="Primario (1º a 8º) Incompleto" <?=$primarioIncom?>>Primário (1º a 8º) Incompleto</option>
								<option value="Primario (1º a 8º) Completo" <?=$primarioCompleto?>>Primário (1º a 8º) Completo</option>
								<option value="Segundo grau Incompleto" <?=$segundoIncom?>>Segundo grau Incompleto</option>
								<option value="Segundo grau Completo" <?=$segundoCompleto?>>Segundo grau Completo</option>
								<option value="Ensino tecnico Incompleto" <?=$tecnicoIncom?>>Ensino técnico Incompleto</option>
								<option value="Ensino tecnico Completo" <?=$tecnicoCompleto?>>Ensino técnico Completo</option>
								<option value="Ensino superior incompleto" <?=$superiorIncom?>>Ensino superior incompleto</option>
								<option value="Ensino superior ompleto"<?=$superiorCompleto?>>Ensino superior Completo</option>
								<option value="Pos graduado" <?=$pos?>>Pós graduado</option>
								<option value="Mestrado" <?=$mestrado?>>Mestrado</option>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Formação Acadêmica:</label>
						<div class="inputs">
							<span class="input_wrapper textarea_wrapper">
								<textarea rows="" cols="" class="text" name="formacaoAcademica"><?=htmlentities($escolaridade->formacaoAcademica)?></textarea>
							</span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Cursos de Idiomas / Cursos Técnicos:</label>
						<div class="inputs">
							<span class="input_wrapper textarea_wrapper">
								<textarea rows="" cols="" class="text" name="cursos"><?=htmlentities($escolaridade->cursos)?></textarea>
							</span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Experiência Profissional</legend>
					    <h1>Último emprego</h1>

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Empresa:</label>
							<div class="inputs">
								<span class="input_wrapper large_input"><input class="text" name="empresa" type="text" value="<?=htmlentities($exp_pri->empresa)?>" /></span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Ramo / Atividade:</label>
							<div class="inputs">
								<span class="input_wrapper large_input"><input class="text" name="ramoAtividade" type="text" value="<?=htmlentities($exp_pri->ramoAtividade)?>" /></span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<div class="inputs">
								<ul>
									<li><span class="input_wrapper"> data admissão<input class="text data" name="dataAdmissao" type="text" value="<?=$exp_pri->dataAdmissao?>" /></span></li>
									<li><span class="input_wrapper">data demissão<input class="text data" name="dataDemissao" type="text" value="<?=$exp_pri->dataDemissao?>" /></span></li>
								</ul>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Motivo de saída:</label>
							<div class="inputs">
								<span class="input_wrapper large_input"><input class="text" name="motivoSaida" type="text" value="<?=htmlentities($exp_pri->motivoSaida)?>" /></span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Salário:</label>
							<div class="inputs">
								<span class="input_wrapper medium_input"><input class="text" name="salario" type="text" value="<?=htmlentities($exp_pri->salario)?>" /></span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Função / Cargo:</label>
							<div class="inputs">
								<select name="funcaoCargo">
									<option value="">Selecione</option>
									<?php

									$criterio = new TCriteria;
									$criterio->add(new TFilter('id', '>', '0' ));

									$repositorio = new TRepository("Funcao");
									$funcoes = $repositorio->load($criterio);

									if($funcoes)
									{
										foreach($funcoes as $funcao)
										{
											if($pessoa->funcaoCargo == $funcao->Funcao) $selected = "selected='selected'"; else $selected = "";
											echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
										}
									}

									?>
								</select>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Atividades Desenvolvidas:</label>
							<div class="inputs">
								<span class="input_wrapper textarea_wrapper">
									<textarea rows="" cols="" class="text" name="atividadesDesenvolvidas"><?=htmlentities($exp_pri->atividadesDesenvolvidas)?></textarea>
								</span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->

						<h1>Penúltimo emprego</h1>

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Empresa:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="PEempresa" type="text" value="<?=htmlentities($exp_pen->empresa)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Ramo / Atividade:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="PEramoAtividade" type="text" value="<?=htmlentities($exp_pen->ramoAtividade)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<div class="inputs">
									<ul>
										<li><span class="input_wrapper"> data admissão<input class="text data" name="PEdataAdmissao" type="text" value="<?=$exp_pen->dataAdmissao?>" /></span></li>
										<li><span class="input_wrapper">data demissão<input class="text data" name="PEdataDemissao" type="text" value="<?=$exp_pen->dataDemissao?>" /></span></li>
									</ul>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Motivo de saída:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="PEmotivoSaida" type="text" value="<?=htmlentities($exp_pen->motivoSaida)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Salário:</label>
								<div class="inputs">
									<span class="input_wrapper medium_input"><input class="text" name="PEsalario" type="text" value="<?=$exp_pen->salario?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Função / Cargo:</label>
								<div class="inputs">
									<select name="PEfuncaoCargo">
										<option value="">Selecione</option>
										<?php

										$criterio = new TCriteria;
										$criterio->add(new TFilter('id', '>', '0' ));

										$repositorio = new TRepository("Funcao");
										$funcoes = $repositorio->load($criterio);

										if($funcoes)
										{
											foreach($funcoes as $funcao)
											{
												if($pessoa->funcaoCargo == $funcao->Funcao) $selected = "selected='selected'"; else $selected = "";
												echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
											}
										}

										?>
									</select>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Atividades Desenvolvidas:</label>
								<div class="inputs">
									<span class="input_wrapper textarea_wrapper">
										<textarea rows="" cols="" class="text" name="PEatividadesDesenvolvidas"><?=htmlentities($exp_pen->atividadesDesenvolvidas)?></textarea>
									</span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
						<h1>Ante penúltimo emprego</h1>

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Empresa:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="ANempresa" type="text" value="<?=htmlentities($exp_ant->empresa)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Ramo / Atividade:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="ANramoAtividade" type="text" value="<?=htmlentities($exp_ant->ramoAtividade)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<div class="inputs">
									<ul>
										<li><span class="input_wrapper"> data admissão<input class="text data" name="ANdataAdmissao" type="text" value="<?=$exp_ant->dataAdmissao?>" /></span></li>
										<li><span class="input_wrapper">data demissão<input class="text data" name="ANdataDemissao" type="text" value="<?=$exp_ant->dataDemissao?>" /></span></li>
									</ul>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Motivo de saída:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="ANmotivoSaida" type="text" value="<?=htmlentities($exp_ant->motivoSaida)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Salário:</label>
								<div class="inputs">
									<span class="input_wrapper medium_input"><input class="text" name="ANsalario" type="text" value="<?=htmlentities($exp_ant->salario)?>" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Função / Cargo:</label>
								<div class="inputs">
									<select name="ANfuncaoCargo">
										<option value="">Selecione</option>
										<?php

										$criterio = new TCriteria;
										$criterio->add(new TFilter('id', '>', '0' ));

										$repositorio = new TRepository("Funcao");
										$funcoes = $repositorio->load($criterio);

										if($funcoes)
										{
											foreach($funcoes as $funcao)
											{
												if($pessoa->funcaoCargo == $funcao->Funcao) $selected = "selected='selected'"; else $selected = "";
												echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
											}
										}

										?>
									</select>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Atividades Desenvolvidas:</label>
								<div class="inputs">
									<span class="input_wrapper textarea_wrapper">
										<textarea rows="" cols="" class="text" name="ANatividadesDesenvolvidas"> <?=htmlentities($exp_ant->atividadesDesenvolvidas)?></textarea>
									</span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Pretensões</legend>
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 1:</label>
						<div class="inputs">
							<select name="primeiraFuncao">
								<option value="">Selecione</option>
								
								<?php

								$criterio = new TCriteria;
								$criterio->add(new TFilter('id', '>', '0' ));

								$repositorio = new TRepository("Funcao");
								$funcoes = $repositorio->load($criterio);
								if($funcoes)
								{
									foreach($funcoes as $funcao)
									{
										if($funcao->id == $pretensoes->primeiraFuncao) $selected = "selected='selected'";
										else $selected = "";
										echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
									}
								}

								?>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 2:</label>
						<div class="inputs">
							<select name="segundaFuncao">
								<option value="">Selecione</option>
								<?php

								if($funcoes)
								{
									foreach($funcoes as $funcao)
									{
										if($funcao->id == $pretensoes->segundaFuncao) $selected = "selected='selected'";
										else $selected = "";
										echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
									}
								}

								?>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Função 3:</label>
						<div class="inputs">
							<select name="terceiraFuncao">
								<option value="">Selecione</option>
								<?php

								if($funcoes)
								{
									foreach($funcoes as $funcao)
									{
										if($funcao->id == $pretensoes->terceiraFuncao) $selected = "selected='selected'";
										else $selected = "";
										echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
									}
								}

								?>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Salário Pretendido:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text" name="salarioPretendido" type="text" value="<?=$pretensoes->salarioPretendido?>" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<?php
					
					if($pretensoes->horario == "Diurno") $diurno = "selected='selected'";
					elseif($pretensoes->horario == "Noturno") $noturno = "selected='selected'";
					
					if($pretensoes->deficiencia == "Visual") $visual = "selected='selected'";
					elseif($pretensoes->deficiencia == "Motora") $motora = "selected='selected'";
					elseif($pretensoes->deficiencia == "Psicologica") $psicologica = "selected='selected'";
					
					?>
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Disponibilidade para trabalhar em qualquer horário?</label>
						<div class="inputs">
							<select name="horario">
								<option value="">Selecione</option>
								<option value="Diurno" <?=$diurno?>>Diurno</option>
								<option value="Noturno" <?=$noturno?>>Noturno</option>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Possui alguma deficiência?</label>
						<div class="inputs">
							<select name="deficiencia">
								<option value="">Selecione</option>
								<option value="Visual" <?=$visual?>>Visual</option>
								<option value="Motora" <?=$motora?>>Motora</option>
								<option value="Psicologica" <?=$psicologica?>>Psicológica</option>
							</select>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			</div>
			<!--[if !IE]>end forms<![endif]-->	
	        <p>
	            <input id="SalvarCV" type="submit" name="submit" value="Salvar Currículo" />
	        </p>
	</form>
	<!--[if !IE]>end forms<![endif]-->

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


