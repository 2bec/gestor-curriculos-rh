<?php

$cv = $_REQUEST['id'];
// inicia transa√ß√£o com o banco 'my_gcrh'
TTransaction::open('my_gcrh');

// define o arquivo para LOG
TTransaction::setLogger(new TLoggerTXT('log-lista-negra.txt'));

// armazena esta frase no arquivo de LOG
TTransaction::log("** LOG INCLUIR NA LISTA NEGRA **");

$id = $_REQUEST['id'];
$pessoa = new Pessoa($id);

?>
<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Incluir currículo na lista negra</h2>
		<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">
	
	<!--[if !IE]>start forms<![endif]-->
	<form id="cadastroLN" action="grava-lista-negra.php" class="search_form general_form" method="post">
			<input type="hidden" class="hidden" name="id" value="<?=$id?>">
			<!--[if !IE]>start forms<![endif]-->
			<div class="forms_">
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Dados do currículo</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Nome:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text required" name="nome" value="<?=$pessoa->nome?>" id="nomeLN" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Data nascimento:</label>
					<div class="inputs">
						<span class="input_wrapper meddium_input"><input class="text required data" name="dataNascimento" value="<?=$pessoa->dataNascimento?>" id="dnLN" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>CPF:</label>
					<div class="inputs">
						<span class="input_wrapper meddium_input"><input class="text required cpf" name="cpf" value="<?=$pessoa->cpf?>" id="cpfLN" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Texto:</label>
					<div class="inputs">
						<span class="input_wrapper textarea_wrapper">
							<textarea rows="" cols="" class="text" name="listaNegra"><?=$pessoa->listaNegra?></textarea>
						</span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			</div>
			<!--[if !IE]>end forms<![endif]-->	
	        <p>
	            <input id="SalvarLN" type="submit" value="Salvar na lista negra" />
	        </p>
	</form>
	<!--[if !IE]>end forms<![endif]-->

</div>
<!--[if !IE]>end section inner<![endif]-->


</div>
<!--[if !IE]>end section<![endif]-->

