
</div>
<!--[if !IE]>end info<![endif]-->



<!--[if !IE]>start sidebar<![endif]-->
<div id="sidebar">
	<?php
	
	if(defined("LISTA")){
		echo '
		<!--[if !IE]>start sidebar module<![endif]-->
		<div class="sidebar_module">
			<div class="title_wrapper">
				<h3>Buscar</h3>
			</div>
			<!--[if !IE]>start forms<![endif]-->
			<form id="busca-cv" action="admin.php?op=lista" class="" method="post">
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$nomecheck.' Nome: <input type="text" style="width:175px" name="nome" id="nome" value="'.$nome.'" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$cpfcheck.' CPF: &nbsp;&nbsp;&nbsp;<input type="text" style="width:175px" name="cpf" id="cpf" value="'.$cpf.'" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
			<!--[if !IE]>start row<![endif]-->
			<div class="row" style="margin-top:5px">
				<div class="inputs">
					'.$expFcheck.' Experiencia: <input type="text" style="width:141px" name="expField" id="expField" value="'.$expField.'" />
				</div>
			</div>
			<!--[if !IE]>end row<![endif]-->
			
		<!--[if !IE]>start row<![endif]-->
		<div class="row" style="margin-top:5px">
			<div class="inputs">
				'.$cursoscheck.' Cursos: <input type="text" style="width:170px" name="cursosField" id="cursosField" value="'.$cursosField.'" />
			</div>
		</div>
		<!--[if !IE]>end row<![endif]-->
				
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">';
					$a = "";
					$b="";
					$c="";
					$d="";
					$null = "";
					switch($habilitacao)
					{
						case "A":
							$a = "selected";
							break;;
						case "B":
							$b = "selected";
							break;;
						case "C":
							$c = "selected";
							break;;
						case "D":
							$d = "selected";
							break;;
						case "E":
							$e = "selected";
							break;;
						default:
							$null = "selected";
							break;;
					}
					echo ''.$cnhcheck.' <select name="habilitacao" id="habilitacao">
							<option value="" '.$null.'>Habilitação</option>
							<option value="A" '.$a.'>A</option>
							<option value="B" '.$b.'>B</option>
							<option value="C" '.$c.'>C</option>
							<option value="D" '.$d.'>D</option>
							<option value="E" '.$e.'>E</option>
						</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">';
					$masculino = "";
					$feminino="";
					$null = "";
					switch($sexo)
					{
						case "Feminino":
							$feminino = "selected";
							break;;
						case "Masculino":
							$masculino = "selected";
							break;;
						default:
							$null = "selected";
							break;;
					}
					echo ''.$sexocheck.' 
						<select name="sexo" id="sexo">
							<option value="" selected>Sexo</option>
							<option value="Masculino" '.$masculino.'>Masculino</option>
							<option value="Feminino" '.$feminino.'>Feminino</option>
						</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">';
					$solteiro = "";
					$casado="";
					$divorciado="";
					$outro="";
					$null = "";
					switch($estadoCivil)
					{
						case "Solteiro":
							$solteiro = "selected";
							break;;
						case "Casado":
							$casado = "selected";
							break;;
						case "Divorciado":
							$divorciado = "selected";
							break;;
						case "Outro":
							$outro = "selected";
							break;;
						default:
							$null = "selected";
							break;;
					}
					echo ''.$estadoCivilcheck.' 
						<select name="estadoCivil" id="estadoCivil">
							<option value="" '.$null.'>Estado Civil</option>
							<option value="Solteiro" '.$solteiro.'>Solteiro</option>
							<option value="Casado" '.$casado.'>Casado</option>
							<option value="Divorciado" '.$divorciado.'>Divorciado</option>
							<option value="Outro" '.$outro.'>Outro</option>
						</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$ufcheck.' <select name="estado" id="estado">
						<option value="" >Selecione um estado</options>';
						try
						{

						    // inicia transação com o banco 'my_dinamica'
						    TTransaction::open('my_dinamica');

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
								foreach($estados as $mestado)
								{
									if($estado == $mestado->uf){$selected = "selected";}else{$selected="";}
									echo '<option value="'.$mestado->uf.'" '.$selected.'>'.htmlentities($mestado->nome).'</option>';
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

				  echo '</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$cidadecheck.' <select name="cidade" id="cidade" style="width:210px">
							<option value="" selected>Selecione uma cidade</option>';
							try
							{

							    // inicia transação com o banco 'my_dinamica'
							    TTransaction::open('my_dinamica');

							    // define o arquivo para LOG
							    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

							    // armazena esta frase no arquivo de LOG
							    TTransaction::log("** LOG LISTAR CIDADES **");

								$criterio = new TCriteria;
								$criterio->add(new TFilter('uf', '=', "$estado" ));

								$repositorio = new TRepository("Cidade");
								$cidades = $repositorio->load($criterio);
								if($cidades)
								{
									foreach($cidades as $mcidade)
									{
										if($cidade == $mcidade->id){$selected = "selected";}else{$selected="";}
										echo '<option value="'.$mcidade->id.'" '.$selected.'>'.htmlentities($mcidade->nome).'</option>';
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

					  echo '</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
					
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$bairrocheck.' Bairro: <input type="text" style="width:170px" name="bairro" id="bairro" value="'.$bairro.'" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
								
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						'.$funcaocheck.' <select name="funcaoCargo" id="funcaoCargo" style="width:230px">
							<option value="" selected>Função / Cargo</option>';
							
						    // inicia transação com o banco 'my_dinamica'
						    TTransaction::open('my_dinamica');

						    // define o arquivo para LOG
						    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

						    // armazena esta frase no arquivo de LOG
						    TTransaction::log("** LOG LISTAR FUNCOES **");

							$criterio = new TCriteria;
							$criterio->add(new TFilter('id', '>', '0' ));

							$repositorio = new TRepository("Funcao");
							$funcoes = $repositorio->load($criterio);
							
							if($funcoes)
							{
								foreach($funcoes as $funcao)
								{
									if($funcaoCargo == $funcao->id){$selected="selected";}else{$selected="";}
									echo '<option value="'.$funcao->id.'" '.$selected.'>'.htmlentities($funcao->Funcao).'</option>';
								}
							}


						echo '</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
					<!--[if !IE]>start row<![endif]-->
					<div class="row" style="margin-top:5px">
						<div class="inputs">
							'.$salariocheck.' Salário: <input type="text" style="width:170px" name="salario" id="salario" value="'.$salario.'" />
						</div>
					</div>
					<!--[if !IE]>end row<![endif]-->
					
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">';
					$visual = "";
					$motora="";
					$psicologica="";
					$null = "";
					switch($deficiencia)
					{
						case "Visual":
							$visual = "selected";
							break;;
						case "Motora":
							$motora = "selected";
							break;;
						case "Psicologica":
							$psicologica = "selected";
							break;;
						default:
							$null = "selected";
							break;;
					}
					echo ''.$deficienciacheck.' 
						<select name="deficiencia" id="deficiencia">
							<option value="" '.$null.'>Selecione uma deficiência</option>
							<option value="Visual" '.$visual.'>Visual</option>
							<option value="Motora" '.$motora.'>Motora</option>
							<option value="Psicologica" '.$psicologica.'>Psicologica</option>
						</select>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">';
					if($experiencia){$check = "checked";}else{$check="";}
					echo'
						<input type="checkbox" name="experiencia" id="experiencia" '.$check.' /> <label for="experiencia">com experiência</label>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs" style="float:right">
						<input type="submit" name="submit" class="button" id="" value="Buscar" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			</form>	
			<!--[if !IE]>end forms<![endif]-->
		</div>
		<!--[if !IE]>end sidebar module<![endif]-->';
	}elseif(defined("Curriculo")){
		echo'
		<!--[if !IE]>start sidebar module<![endif]-->
		<div class="sidebar_module">
				<div class="title_wrapper" style="display:block;padding:10px 0">
					<h3>Parecer</h3>
				</div>	

				<!--[if !IE]>start forms<![endif]-->
				<form id="formParecer" action="parecer.php" class="" method="post">
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						<ul style="display:inline">';

					    // inicia transação com o banco 'my_dinamica'
					    TTransaction::open('my_dinamica');

					    // define o arquivo para LOG
					    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

					    // armazena esta frase no arquivo de LOG
					    TTransaction::log("** LOG LISTAR PARECER **");


						$criterio = new TCriteria;
						$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
						$repositorio = new TRepository("Parecer");
						$countP = $repositorio->count($criterio);
						$parecer = $repositorio->load($criterio);
						$parecer = $parecer[0];
						if($countP){$value="edit";}else{$value="insert";}
						echo '
						<textarea class="text anota" name="parecerTxt" style="border:1px solid #888;width:98%;height:200px">'.$parecer->texto.'</textarea>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs" style="float:right">
						<input type="hidden" name="op" id="parecerValue" value="'.$value.'" />
						<input type="hidden" name="id" value="'.$pessoa->id.'" />
						<input type="submit" name="submit" class="button" id="btnParecer" value="Atualizar Parecer" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				</form>
				<!--[if !IE]>end form<![endeif]-->
				<br /><br />
				<div class="title_wrapper">
					<h3>Anotações</h3>
				</div>	

				<!--[if !IE]>start forms<![endif]-->
				<form id="formAnota" action="anota.php" class="" method="post">
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						<ul style="display:inline">';

					    // inicia transação com o banco 'my_dinamica'
					    TTransaction::open('my_dinamica');

					    // define o arquivo para LOG
					    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

					    // armazena esta frase no arquivo de LOG
					    TTransaction::log("** LOG LISTAR ANOTACOES **");


						$criterio = new TCriteria;
						$criterio->add(new TFilter('idPessoa', '=', $pessoa->id ));
						$repositorio = new TRepository("Anotacao");
						$countA = $repositorio->count($criterio);
						$anotacoes = $repositorio->load($criterio);
						$anotacao = $anotacoes[0];		
						if($countA){$V = "edit";}else{$V="insert";}
						echo '<textarea class="text anota" name="anotaTxt" style="border:1px solid #888;width:98%;height:200px">'.$anotacao->texto.'</textarea>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->

				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs" style="float:right">
						<input type="hidden" name="op" id="anotaValue" value="'.$V.'" />
						<input type="hidden" name="id" value="'.$pessoa->id.'" />
						<input type="submit" name="submit" class="button" id="btnAnota" value="Atualizar Anotação" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				</form>
				<!--[if !IE]>end form<![endeif]-->

				
		</div>
		<!--[if !IE]>end sidebar module<![endif]-->';
	}
	
	?>
	<br /><br />
	<!--[if !IE]>start sidebar module<![endif]-->
	<div class="sidebar_module">
		<div class="title_wrapper">
			<h3>Estatísticas</h3>
		</div>
		<div id="statistics">
			<dl>
				<dt>Total de currículos</dt>
				<dd>
					<?php
					
				    // inicia transação com o banco 'my_dinamica'
				    TTransaction::open('my_dinamica');

				    // define o arquivo para LOG
				    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

				    // armazena esta frase no arquivo de LOG
				    TTransaction::log("** LOG CONTAR PESSOAS **");

					$criterio = new TCriteria;
					$criterio->add(new TFilter('id', '>', '0'));
					$repositorio = new TRepository("Pessoa");
					$count = $repositorio->count($criterio);
					
					echo "$count";
					
					?>
				</dd>
			</dl>
			<dl>
				<dt>Total de vagas</dt>
				<dd>
					<?php
					
				    // inicia transação com o banco 'my_dinamica'
				    TTransaction::open('my_dinamica');

				    // define o arquivo para LOG
				    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

				    // armazena esta frase no arquivo de LOG
				    TTransaction::log("** LOG CONTAR VAGAS **");

					$criterio = new TCriteria;
					$criterio->add(new TFilter('id', '>', '0'));
					$repositorio = new TRepository("Vaga");
					$count = $repositorio->count($criterio);
					
					echo "$count";
					
					?>
				</dd>
			</dl>
			<dl>
				<dt>Curículos ativos</dt>
				<dd>
					<?php
					
				    // inicia transação com o banco 'my_dinamica'
				    TTransaction::open('my_dinamica');

				    // define o arquivo para LOG
				    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

				    // armazena esta frase no arquivo de LOG
				    TTransaction::log("** LOG CONTAR CV ATIVOS **");

					$criterio = new TCriteria;
					$criterio->add(new TFilter('ativo', '=', 'ativo'));
					$repositorio = new TRepository("Pessoa");
					$count = $repositorio->count($criterio);
					
					echo "$count";
					
					?>
				</dd>
			</dl>
			<dl>
				<dt>Currículos desativados (esperando)</dt>
				<dd>
					<?php
					
				    // inicia transação com o banco 'my_dinamica'
				    TTransaction::open('my_dinamica');

				    // define o arquivo para LOG
				    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

				    // armazena esta frase no arquivo de LOG
				    TTransaction::log("** LOG CONTAR CV DESATIVADOS **");

					$criterio = new TCriteria;
					$criterio->add(new TFilter('ativo', '=', 'desativado'));
					$repositorio = new TRepository("Pessoa");
					$count = $repositorio->count($criterio);
					
					echo "$count";
					
					?>
				</dd>
			</dl>
			<dl>
				<dt>Curículos na lista negra</dt>
				<dd>
					<?php
					
				    // inicia transação com o banco 'my_dinamica'
				    TTransaction::open('my_dinamica');

				    // define o arquivo para LOG
				    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

				    // armazena esta frase no arquivo de LOG
				    TTransaction::log("** LOG CONTAR LISTA NEGRA **");

					$criterio = new TCriteria;
					$criterio->add(new TFilter('listaNegra', '!=', 'NULL'));
					$repositorio = new TRepository("Pessoa");
					$count = $repositorio->count($criterio);
					
					echo "$count";
					
					?>
				</dd>
			</dl>
		</div>
	</div>
	<!--[if !IE]>end sidebar module<![endif]-->
		
</div>
<!--[if !IE]>end sidebar<![endif]-->

<?php
?>