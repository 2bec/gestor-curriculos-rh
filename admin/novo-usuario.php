
<!--[if !IE]>start section<![endif]-->
<div class="section">
	
	<div class="title_wrapper">
		<h2>Cadastrar novo Usuário</h2>
		<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
		<div id="product_list_menu"></div>

	</div>
	
	<!--[if !IE]>start section inner <![endif]-->
	<div class="section_inner">
	
	<!--[if !IE]>start forms<![endif]-->
	<form id="cadastroU" action="grava-usuario.php" class="search_form general_form" method="post">
			<!--[if !IE]>start forms<![endif]-->
			<div class="forms_">
			<!--[if !IE]>start fieldset<![endif]-->
			<fieldset>
				<legend>Dados do Usuário</legend>
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Login:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text required" name="login" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Email:</label>
					<div class="inputs">
						<span class="input_wrapper large_input"><input class="text required" name="email" type="text" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Senha:</label>
					<div class="inputs">
						<span class="input_wrapper"><input class="text required" name="senha" type="password" /></span>
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			
				<!--[if !IE]>start row<![endif]-->
				<div class="row">
					<label>Permissões</label>
					<div class="inputs">
						<span class="input_wrapper">
							<select name="permissao">
								<option value="Ler, Editar, Apagar">Ler, Editar, Apagar</option>
								<option value="Ler">Ler</option>
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

