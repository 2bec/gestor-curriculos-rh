<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GCRH - Login</title>
<link rel="stylesheet" type="text/css" href="css/meta-admin-login.css" />
<link rel="stylesheet" type="text/css" href="css/red-theme-login.css" />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/ie-login.css" /><![endif]-->
</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		<!--[if !IE]>start header<![endif]-->
		<div id="header">
			<div class="inner">
				<h1 id="logo"><a href="#">GCRH</a></h1>
			</div>
		</div>
		<!--[if !IE]>end header<![endif]-->
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
				<!--[if !IE]>start login_wrapper<![endif]-->
				<div id="login_wrapper">
					<span class="extra1"></span>
					<div class="title_wrapper">
						<h2>Faça seu login</h2>
						<!-- <a href="#">Esqueci minha senha</a> -->
					</div> 
					<form action="login.php" method="post">
						<fieldset>
						<?php

						if($_GET['erro'] == "login"){
							echo '<div class="row" style="color:red">* Login inválido!</div>';
						}elseif($_GET['erro'] == "senha"){
							echo '<div class="row" style="color:red">* Senha é obrigatório!</div>';							
						}elseif($_GET['erro'] == "pass"){
							echo '<div class="row" style="color:red">* Senha inválida!</div>';							
						}

						?>
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Login:</label>
								<span class="input_wrapper">
									<input class="text" name="login" value="<?=base64_decode($_GET['l'])?>" type="text" />
								</span>
							</div>
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<div class="row">
								<label>Senha:</label>
								<span class="input_wrapper">
									<input class="text" name="senha" type="password" />
								</span>
							</div>	
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
							<!-- <div class="row">
								<label class="inline"><input class="checkbox" name="" type="checkbox" value="" /> Lembrar me</label>
							</div> -->
							<!--[if !IE]>end row<![endif]-->
							<!--[if !IE]>start row<![endif]-->
								<div class="row">
									<div class="inputs small_inputs">
										<span class="button blue_button unlock_button"><span><span><em><span class="button_ico"></span>Entrar</em></span></span><input name="" type="submit" /></span>
										<a href="../index.php" class="button gray_button"><span><span>Voltar ao site</span></span></a> 
									</div>
								</div>
								<!--[if !IE]>end row<![endif]-->
						</fieldset>
					</form>
				</div>
				<!--[if !IE]>end login_wrapper<![endif]-->
			
		</div>
		<!--[if !IE]>end content<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
</body>
</html>
