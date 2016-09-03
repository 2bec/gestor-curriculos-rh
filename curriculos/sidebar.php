
</div>
<!--[if !IE]>end info<![endif]-->



<!--[if !IE]>start sidebar<![endif]-->
<div id="sidebar">
	<?php
	
	$cpf = base64_decode($_GET[l]);
	
	$user = $_COOKIE["mycv"];
	
	if(defined("LOGIN"))
	{
		echo '
		<!--[if !IE]>start sidebar module<![endif]-->
		<div class="sidebar_module">
			<div class="title_wrapper">
				<h3>Login</h3>
			</div>
			<!--[if !IE]>start forms<![endif]-->
			<form id="login-cv" action="login.php" class="" method="post">
				<br /><p>Se você já possui o currículo cadastrado por favor entre com CPF e data de nascimento para poder realizar alterações nos seus dados.</p>
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						<label>CPF:</label><br /><input type="text" style="width:180px" class="cpf" name="cpf_log" id="cpf_log" value="'.$cpf.'" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs">
						<label>NASCIMENTO:</label><br /><input type="text" style="width:180px" class="data" name="nasc_log" id="nasc_log" value="'.$nasc.'" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
				
				<!--[if !IE]>start row<![endif]-->
				<div class="row" style="margin-top:5px">
					<div class="inputs" style="float:right">
						<input type="submit" name="submit" class="button" id="" value="Login" />
					</div>
				</div>
				<!--[if !IE]>end row<![endif]-->
			</form>	
			<!--[if !IE]>end forms<![endif]-->
		</div>
		<!--[if !IE]>end sidebar module<![endif]-->';
	}elseif(is_user($user)){
		echo '
		<!--[if !IE]>start sidebar module<![endif]-->
		<div class="sidebar_module">
			<div class="title_wrapper">
				<h2>Bem vindo</h2>
			</div>	
			<br /><p>Você esta logado como <strong>'.$pessoa->nome.'</strong>, para <a href="logout.php">sair clique aqui</a>.</p>
			<p>Seu IP: '.$_SERVER["REMOTE_ADDR"].'</p>
			<p>Para sua segurança todas as suas ações estão sendo gravadas em arquivos de log.</p>
		</div>
		<!--[if !IE]>end sidebar module<![endif]-->';
	}

	?>
</div>
<!--[if !IE]>end sidebar<![endif]-->

<?php
?>