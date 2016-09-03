<?php


try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR USUARIO **");
	
	$id = $_GET['id'];
	$usuario = new Usuario($id);
	
?>


<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Editar Usuário</h2>
		<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">
	
	<!--[if !IE]>start forms<![endif]-->
	<form id="editaU" action="edita-usuario.php" class="search_form general_form" method="post">
	<input class="hidden required" name="user_id" value="<?=$usuario->id?>" type="hidden" />
			<!--[if !IE]>start forms<![endif]-->
			<div class="forms_">
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Dados do Usuário</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Login:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text required" name="login" value="<?=$usuario->login?>" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Email:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text required" name="email" value="<?=base64_decode($usuario->email)?>" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Senha:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text required" name="senha" type="password" /></span> (insira sua nova senha)
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Permissões</label>
					<div class="inputs">
						<span class="input_wrapper">
							<select name="permissao">
								<?php
								
								if($usuario->permissao == "Ler, Editar, Apagar")
								{
									$selectedT = 'selectected';
								}else{
									$selectedL = 'selected';
								}
								
								?>
								<option value="Ler, Editar, Apagar" <?=$seletecdT?>>Ler, Editar, Apagar</option>
								<option value="Ler" <?=$selectedL?>>Ler</option>
							</select>
						</span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			</fieldset>
			<!--[if !IE]>end fieldset<![endif]-->
			
			</div>
			<!--[if !IE]>end forms<![endif]-->	
	        <p>
	            <input id="SalvarU" type="submit" value="Salvar Usuário" />
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