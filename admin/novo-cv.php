
	<!--[if !IE]>start section<![endif]-->
	<div class="section">
		
		<div class="title_wrapper">
			<h2>Cadastrar novo currículo</h2>
			
			<div id="product_list_menu"></div>

		</div>
		
		<!--[if !IE]>start section inner <![endif]-->
		<div class="section_inner">
		
		<!--[if !IE]>start forms<![endif]-->
		<form id="cadastroCV" action="grava-cv.php" class="search_form general_form" method="post">
				<!--[if !IE]>start forms<![endif]-->
				<div class="forms_">
				<h5>Campos com ( * ) são obrigatórios !</h5>
				
				
				<!--[if !IE]>start fieldset<![endif]-->
				<fieldset>
					<legend>Dados Pessoais</legend>
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Nome:</label>
						<div class="inputs">
							<span class="input_wrapper large_input"><input class="text" name="nome" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* CPF:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text cpf" name="cpf" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* RG:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text" name="rg" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Data nascimento:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text data" name="dataNascimento" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Sexo:</label>
						<div class="inputs">
							<ul>
								<li><input id="masculino" class="radio" name="sexo" value="Masculino" type="radio" /> <label class="normal" for="masculino">Masculino</label></li>
								<li><input id="feminino" class="radio" name="sexo" value="Feminino" type="radio" /> <label class="normal" for="feminino">Feminino</label></li>
							</ul>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Estado civil:</label>
						<div class="inputs">
							<ul class="">
								<li> <input id="solteiro" class="radio" name="estadoCivil" value="Solteiro" type="radio" /> <label class="normal" for="solteiro"> Solteiro</label></li>
								<li> <input id="casado" class="radio" name="estadoCivil" value="Casado" type="radio" /> <label class="normal" for="casado"> Casado</label></li>
								<li> <input id="divorciado" class="radio" name="estadoCivil" value="Divorciado" type="radio" /> <label class="normal" for="divorciado"> Divorciado</label></li>
								<li> <input id="outro" class="radio" name="estadoCivil" value="Outro" type="radio" /> <label class="normal" for="outro"> Outro</label></li>
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
						<label>* Endereço:</label>
						<div class="inputs">
							<span class="input_wrapper large_input"><input class="text" name="endereco" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Bairro:</label>
						<div class="inputs">
							<span class="input_wrapper large_input"><input class="text" name="bairro" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Estado:</label>
						<div class="inputs">
							<ul>
								<li><span class="input_wrapper">
									<select name="estado" id="estado">
								<?php
								
									try
									{

									    // inicia transação com o banco 'my_gcrh'
									    TTransaction::open('my_gcrh');

									    // define o arquivo para LOG
									    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

									    // armazena esta frase no arquivo de LOG
									    TTransaction::log("** LOG LISTAR ESTADOS **");

										$criterio = new TCriteria;
										$criterio->add(new TFilter('id', '>', '0' ));

										$repositorio = new TRepository("Estado");
										$estados = $repositorio->load($criterio);
										if($estados)
										{
											foreach($estados as $estado)
											{
												echo '<option value="'.$estado->uf.'">'.htmlentities($estado->nome).'</option>';
											}
										}

									}
									catch (Exception $e) // em caso de exceção
									{
									    // exibe a mensagem gerada pela exceção
									    echo '<b>Erro</b>' . $e->getMessage();
									    // desfaz todas alterações no banco de dados
									    TTransaction::rollback();
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
						<label>* Cidade:</label>
						<div class="inputs">
							<span class="input_wrapper">
								<select name="cidade" id="cidade">
									<option value="">Selecione um estado</option>
								</select>
							</span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>* Fone Resid.:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text fone" name="foneResidencial" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Fone Celular:</label>
						<div class="inputs">
							<span class="input_wrapper"><input class="text fone" name="foneCelular" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Fone Contato:</label>
						<div class="inputs">
							<span class="input_wrapper" style="text-align:center;font-size:.7em">Telefone Contato <input class="text fone required" name="foneRecado" type="text" /></span>
							<span class="input_wrapper" style="text-align:center;font-size:.7em">Nome Contato <input class="text required" name="falarCom" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row">
						<label>Email:</label>
						<div class="inputs">
							<span class="input_wrapper large_input"><input class="text" name="email" type="text" /></span>
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
				</fieldset>
				<!--[if !IE]>end fieldset<![endif]-->
				
				
				<!--[if !IE]>start fieldset<![endif]-->
				<fieldset>
					<legend>Educação</legend>
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Escolaridade:</label>
							<div class="inputs">
								<select name="nivel">
									<option value="Primário (1º a 8º) Incompleto">Primário (1º a 8º) Incompleto</option>
									<option value="Primário (1º a 8º) Completo">Primário (1º a 8º) Completo</option>
									<option value="Segundo grau Incompleto">Segundo grau Incompleto</option>
									<option value="Segundo grau Completo">Segundo grau Completo</option>
									<option value="Ensino técnico Incompleto">Ensino técnico Incompleto</option>
									<option value="Ensino técnico Completo">Ensino técnico Completo</option>
									<option value="Ensino superior incompleto">Ensino superior incompleto</option>
									<option value="Ensino superior Completo">Ensino superior Completo</option>
									<option value="Pós graduado">Pós graduado</option>
								</select>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Formação Acadêmica:</label>
							<div class="inputs">
								<span class="input_wrapper textarea_wrapper">
									<textarea rows="" cols="" class="text" name="formacaoAcademica"></textarea>
								</span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Cursos de Idiomas / Cursos Técnicos:</label>
							<div class="inputs">
								<span class="input_wrapper textarea_wrapper">
									<textarea rows="" cols="" class="text" name="cursos"></textarea>
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
									<span class="input_wrapper large_input"><input class="text" name="empresa" type="text" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Ramo / Atividade:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="ramoAtividade" type="text" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<div class="inputs">
									<ul>
										<li><span class="input_wrapper"> data admissão<input class="text data" name="dataAdmissao" type="text" /></span></li>
										<li><span class="input_wrapper">data demissão<input class="text data" name="dataDemissao" type="text" /></span></li>
									</ul>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Motivo de saída:</label>
								<div class="inputs">
									<span class="input_wrapper large_input"><input class="text" name="motivoSaida" type="text" /></span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->

							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Salário:</label>
								<div class="inputs">
									<span class="input_wrapper medium_input"><input class="text" name="salario" type="text" /></span>
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
										
										if($funcoes){
											foreach($funcoes as $funcao){
												echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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
										<textarea rows="" cols="" class="text" name="atividadesDesenvolvidas"></textarea>
									</span>
								</div>
							</div>
							<!--[if !IE]>end row<![endif]-->
							
							<h1>Penúltimo emprego</h1>
							
								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Empresa:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="PEempresa" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Ramo / Atividade:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="PEramoAtividade" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<div class="inputs">
										<ul>
											<li><span class="input_wrapper"> data admissão<input class="text data" name="PEdataAdmissao" type="text" /></span></li>
											<li><span class="input_wrapper">data demissão<input class="text data" name="PEdataDemissao" type="text" /></span></li>
										</ul>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Motivo de saída:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="PEmotivoSaida" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Salário:</label>
									<div class="inputs">
										<span class="input_wrapper medium_input"><input class="text" name="PEsalario" type="text" /></span>
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

											if($funcoes){
												foreach($funcoes as $funcao){
													echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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
											<textarea rows="" cols="" class="text" name="PEatividadesDesenvolvidas"></textarea>
										</span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->
							<h1>Ante penúltimo emprego</h1>
							
								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Empresa:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="ANempresa" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Ramo / Atividade:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="ANramoAtividade" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<div class="inputs">
										<ul>
											<li><span class="input_wrapper"> data admissão<input class="text data" name="ANdataAdmissao" type="text" /></span></li>
											<li><span class="input_wrapper">data demissão<input class="text data" name="ANdataDemissao" type="text" /></span></li>
										</ul>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Motivo de saída:</label>
									<div class="inputs">
										<span class="input_wrapper large_input"><input class="text" name="ANmotivoSaida" type="text" /></span>
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->

								<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<label>Salário:</label>
									<div class="inputs">
										<span class="input_wrapper medium_input"><input class="text" name="ANsalario" type="text" /></span>
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

											if($funcoes){
												foreach($funcoes as $funcao){
													echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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
											<textarea rows="" cols="" class="text" name="ANatividadesDesenvolvidas"></textarea>
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


									if($funcoes){
										foreach($funcoes as $funcao){
											echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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
									if($funcoes){
										foreach($funcoes as $funcao){
											echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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

									if($funcoes){
										foreach($funcoes as $funcao){
											echo '<option value="'.$funcao->id.'">'.htmlentities($funcao->Funcao).'</option>';
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
								<span class="input_wrapper"><input class="text" name="salarioPretendido" type="text" /></span>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
						<!--[if !IE]>start row<![endif]-->
						<div class="row">
							<label>Disponibilidade para trabalhar em qualquer horário?</label>
							<div class="inputs">
								<select name="horario">
									<option value="">Selecione</option>
									<option value="Diurno">Diurno</option>
									<option value="Noturno">Noturno</option>
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
									<option value="Visual">Visual</option>
									<option value="Motora">Motora</option>
									<option value="Psicologica">Psicológica</option>
								</select>
							</div>
						</div>
						<!--[if !IE]>end row<![endif]-->
				</fieldset>
				<!--[if !IE]>end fieldset<![endif]-->
				
				</div>
				<!--[if !IE]>end forms<![endif]-->	
		        <p>
		            <input id="SalvarCV" type="submit" name="submit" value="Cadastrar Currículo" />
		        </p>
		</form>
		<!--[if !IE]>end forms<![endif]-->
	
	</div>
	<!--[if !IE]>end section inner<![endif]-->
	
	
	</div>
	<!--[if !IE]>end section<![endif]-->
	
