<?php


try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR VAGA **");
	
	$id = $_GET['id'];
	$vaga = new Vaga($id);
	
?>


<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Editar Vaga</h2>
		<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">
	
	<!--[if !IE]>start forms<![endif]-->
	<form id="editaV" action="edita-vaga.php" class="search_form general_form" method="post">
	<input class="hidden required" name="vaga_id" value="<?=$vaga->id?>" type="hidden" />
			<!--[if !IE]>start forms<![endif]-->
			<div class="forms_">
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Dados da Vaga</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Título:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text required" name="titulo" value="<?=$vaga->titulo?>" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Descrição:</label>
					<div class="inputs">
						<span class="input_wrapper textarea_wrapper">
							<textarea rows="" cols="" class="text" name="descricao"><?=$vaga->descricao?></textarea>
						</span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			</div>
			<!--[if !IE]>end forms<![endif]-->	
	        <p>
	            <input id="SalvarV" type="submit" value="Salvar Vaga" />
	        </p>
	</form>
	<!--[if !IE]>end forms<![endif]-->

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