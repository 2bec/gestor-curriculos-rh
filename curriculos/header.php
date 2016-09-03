<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GCRH Envio de Currículo</title>
<link rel="stylesheet" type="text/css" href="css/meta-admin.css" />
<link rel="stylesheet" type="text/css" href="css/red-theme.css" />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->

<style type="text/css">
    fieldset { border:none; width:320px;}
    legend { font-size:18px; margin:0px; padding:10px 0px; color:#b0232a; font-weight:bold;}
    input[type=text], input[type=password] { width:300px; padding:5px; border:solid 1px #000;}
    .prev, .next { background-color:#f1f1f1; padding:5px 10px; color:#fff; text-decoration:none;}
    .prev:hover, .next:hover { background-color:#101010; text-decoration:none;}
    .prev { float:left;}
    .next { float:right;}
</style>

<script type="text/javascript" src="js/css.js"></script>
<script type="text/javascript" src="js/behaviour.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/formSteps.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon.font.js"></script>
<script type="text/javascript" src="../js/cufon.cfg.js"></script>



<script type="text/javascript">
    $(document).ready(function(){
        $("#cadastroCV").formToWizard({ submitButton: 'SalvarCV' });

		$("#cadastroCV").submit(function(){
			var options = {
  				success: function(response){
					alert("Seu curriculo foi cadastrado! O currículo ficará ativo somente por 90 (noventa) dias se não houver mais nenhuma alteração!");
					alert(response)
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		$("#editCv").formToWizard({ submitButton: 'SalvaCV' });


		$("#editCv").submit(function(){
			
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Seu curriculo foi editado! O currículo ficara ativo somente por 90 (noventa) dias se não houver mais nenhuma alteração!");
				}
			};
			$(this).ajaxSubmit(options);
			alert("Seu curriculo foi editado! O currículo ficara ativo somente por 90 (noventa) dias se não houver mais nenhuma alteração!")
			return false;
		});
		
			//Append a div with hover class to all the LI
			$('#top-menu li').append('<div class="hover"><\/div>');


			$('#top-menu li').hover(

				//Mouseover, fadeIn the hidden hover class	
				function() {

					$(this).children('div').fadeIn('1000');	

				}, 

				//Mouseout, fadeOut the hover class
				function() {

					$(this).children('div').fadeOut('1000');	

			}).click (function () {

				//Add selected class if user clicked on it
				$(this).addClass('selected');

			});
			
			$("#login-cv").submit(function(){
				var options = {
					success: function(response){
						alert(response);
						window.location="index.php";
					}
				};
				$(this).ajaxSubmit(options);
				return false;
			})

		jQuery(function($){
		   $(".data").mask("99/99/9999");
		   $(".cpf").mask("999.999.999-99");
		   $(".fone").mask("(99) 9999-9999");
		});
		
		$("#estado").change(function(){
			$.post("change.php", {busca: $(this).val()},
			function(data){
				$("#cidade").html(data);
			})
		})
				
    });
</script>

</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			<!--[if !IE]>start content bottom<![endif]-->
			<div id="content_bottom">
			
			<div class="inner">

				<!--[if !IE]>start info<![endif]-->
				<div id="info">