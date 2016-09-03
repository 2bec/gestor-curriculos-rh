<?php

ini_set('default_charset','UTF-8'); // Para o charset das páginas e

/*
 * fun√ß√£o __autoload()
 * carrega uma classe quando ela √à necess√°ria,
 * ou seja, quando ela √© instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
    else
    {
        $classe = strtolower($classe);
        include_once "{$classe}.class.php";
    }
}

function is_user($user) {
	
	// inicia transa√ß√£o com o banco 'my_gcrh'
	TTransaction::open('my_gcrh');

	// define o arquivo para LOG
	TTransaction::setLogger(new TLoggerTXT('log-verificacao.txt'));

	// armazena esta frase no arquivo de LOG
	TTransaction::log("** LOGIN VERIFICACAO **");
	
    if (!$user) { return 0; }
    if (!is_array($user))
    {
        $user = base64_decode($user);
        $user = addslashes($user);
        $user = explode(":", $user);
    	$uid = $user[0];
	    $pwd = $user[2];
	    $uid = intval($uid);
	    if (!empty($uid) AND !empty($pwd))
	    {
			$criterio = new TCriteria;
			$criterio->add(new TFilter('id', '=', "$uid" ));
			$repositorio = new TRepository("Usuario");
			$usuario = $repositorio->load($criterio);
			$usuario = $usuario[0];
			
			// finaliza a transação
			TTransaction::close();
			
	        if ($usuario->senha == $pwd)
	        {
	            static $userSave;
	        	return $userSave = 1;
	        }
	    }	
    }
    static $userSave;
    return $userSave = 0;
}
function calc_idade( $data_nasc ){
	$data_nasc = explode("/", $data_nasc);
	$data = date("d-m-Y");
	$data = explode("-", $data);
	$anos = $data[2] - $data_nasc[2];

	if ($data_nasc[1] >= $data[1])
	{
		if ($data_nasc[0] <= $data[0])
		{
			return $anos; break;
		}else{
			return $anos-1;
			break;
		}
	}else{
		return $anos;
	}
}

$user = $_COOKIE["dinamica"];

if(!is_user($user)){
	header("Location: index.php");
	die();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GCRH Administração de Currículos</title>
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


<script type="text/javascript">
    $(document).ready(function(){
        $("#cadastroCV").formToWizard({ submitButton: 'SalvarCV' });

		
		$("#cadastroCV").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Seu currículo foi cadastrado! O currículo ficara ativo somente por 3 (três) meses a partir da data de inclusão e/ou alteração!");
					window.location="admin.php?op=lista";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
        $("#editaCv").formToWizard({ submitButton: 'SalvarCV' });


		$("#editaCv").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Currículo salvo!  O currículo ficara ativo somente por 3 (três) meses a partir da data de alteração!");
					history.go(-2);
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		$("#cadastroV").submit(function(){
			var options = {
				success: function(response){
					alert("A vaga foi cadastrada!");
					window.location="admin.php?op=lista-vagas";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		$("#cadastroU").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("O usuário foi inserido!");
					window.location="admin.php?op=lista-usuarios";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		function checkEmail() {
			var email = document.getElementById('emailaddress');
			
		}
		$("#enviaEmail").submit(function(){
			var email = $('#emailSet').val();
			var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email)) {
				alert('Email invalido! Por favor confira e tente novamente.');
				$('#emailSet').focus()
				return false;
			}
			var options = {
				success: function(response){
					alert(response);
					history.go(-1);
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		})
		
		$("#cadastroLN").submit(function(){
			//$.cookie("formSalvar", null);
			var nome = $('#nomeLN').val();
			var nascimento = $('#dnLN').val();
			var cpf = $('#cpfLN').val();
			
			if(!cpf){
				alert('O campo CPF nao pode ficar em branco!')
				return false;
			}
			
			var options = {
				success: function(response){
					alert("O usuário foi inserido na lista negra!");
					window.location="admin.php?op=lista-negra";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		$("#editaU").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("O usuário foi salvo!");
					window.location="admin.php?op=lista";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		$("#editaV").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("A vaga foi salva!");
					window.location="admin.php?op=lista-vagas";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		$("#formAnota").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Anotação foi salva!");
					$("#anotaValue").attr('value', "edit");
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		$("#formParecer").submit(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Parecer foi salvo!");
					$("#parecerValue").attr('value', "edit");
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		$(".salvar").click(function(){
			//$.cookie("formSalvar", null);
			var options = {
				success: function(response){
					alert("Currículo salvo!");
					window.location="admin.php?op=lista";
				}
			};
			$(this).ajaxSubmit(options);
			return false;
		});
		
		jQuery(function($){
		   $(".data").mask("99/99/9999");
		   $(".cpf").mask("999.999.999-99");
		   $(".fone").mask("(99) 9999-9999");
		});
		
		
		$("#estado").change(function(){
			$.post("change.php", {busca: $(this).val()},
			function(data){
				$("#cidade").append(data);
			})
		})
		$(".approvedE").click(function(){
			var result = confirm("Deseja desativar esse currículo?");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-cv.php",
					data: "op=desativa&id="+$(this).attr("id"),
					success: function(response){
						window.location="admin.php?op=editar&id="+$(this).attr("id");						
					}
				})
			}
			return false;
		})
		$(".pendingE").click(function(){
			var result = confirm("Deseja ativar esse currículo?");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-cv.php",
					data: "op=ativa&id="+$(this).attr("id"),
					success: function(response){
						window.location="admin.php?op=editar&id="+$(this).attr("id");						
					}
				})
			}
			return false;
		})
		$(".approved").click(function(){
			var result = confirm("Deseja desativar esse currículo?");
			var a = $(this).attr("name");
			var id = $(this).attr("id");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-cv.php",
					data: "op=desativa&id="+$(this).attr("id"),
					success: function(response){
						if(a == "vendo")
							window.location="admin.php?op=ver&cv="+id;
						else if(a == "editando")
							window.location="admin.php?op=editar&cv="+id;
						else
							window.location="admin.php?op=lista";						
					}
				})
			}
			return false;
		})
		$(".pending").click(function(){
			var result = confirm("Deseja ativar esse currículo?");
			var a = $(this).attr("name");
			var id = $(this).attr("id");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-cv.php",
					data: "op=ativa&id="+$(this).attr("id"),
					success: function(response){
						if(a == "vendo")
							window.location="admin.php?op=ver&cv="+id;
						else if(a == "editando")
							window.location="admin.php?op=editar&cv="+id;
						else
							window.location="admin.php?op=lista";						
					}
				})
			}
			return false;
		})
		$(".tirar-lista").click(function(){
			var result = confirm("Deseja retirar esse currículo lista negra?");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "retira-lista.php",
					data: "op=retirar&id="+$(this).attr("id"),
					success: function(response){
						window.location="admin.php?op=lista-negra";						
					}
				})
			}
			return false;
		})
		$(".vaga-ativa").click(function(){
			var result = confirm("Deseja desativar essa vaga? Ela não aparecerá mais no seu site.");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-vaga.php",
					data: "op=desativa&id="+$(this).attr("id"),
					success: function(response){
						window.location="admin.php?op=lista-vagas";						
					}
				})
			}
			return false;
		})
		$(".vaga-desativa").click(function(){
			var result = confirm("Deseja ativar essa vaga? Ela aparecerá na página inicial do seu site.");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "ativa-vaga.php",
					data: "op=ativa&id="+$(this).attr("id"),
					success: function(response){
						window.location="admin.php?op=lista-vagas";						
					}
				})
			}
			return false;
		})
		
		// Mostra janela de confirmação LINK
		$('.delete').click(function(){
			var result = confirm("Deseja realmente excluir esse registro? *Essa ação não poderá ser desfeita!");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "apagar-cv.php",
					data: "id="+$(this).attr("id"),
					success: function(response){
						alert(response);
						window.location="admin.php?op=lista";						
					}
				})
			}
			return false;
		});
		
		// Mostra janela de confirmação LINK
		$('.delete-vaga').click(function(){
			var result = confirm("Deseja realmente excluir esse registro? *Essa ação não poderá ser desfeita!");
			if(result == true){
				$.ajax({   
					type: "POST",
					url: "apagar-vaga.php",
					data: "id="+$(this).attr("id"),
					success: function(response){
						alert(response);
						window.location="admin.php?op=lista-vagas";						
					}
				})
			}
			return false;
		});
		$(function(){
					// bind a click event to the "Add" link
					var newRowNum = 0;
					$('.mais').click(function(){
						newRowNum += 1;
						// get the entire "Add" row --
						// "this" refers to the clicked element
						// and "parent" moves the selection up
						// to the parent node in the DOM
						var addRow = $(this).parent().parent();

						var x=0, old_names=[]
						// these pointless looking loops are because IE doesn't handle
						// cloning the name="" part of dynamic input boxes very well... ?
						$('input',$(this).parent()).each(function(){
							old_names[x++] = $(this).attr('name');
						});
						// copy the entire row from the DOM
						// with "clone"
						var newRow = addRow.clone();
						
						// set the values of the inputs
						// in the "Add" row to empty strings
						$('input', addRow).val('');

						// insert a remove link in the last cell
						$('span:last-child', newRow).html('<a href="" class="remove">-<\/a>');

						x = 0;
						// loop through the inputs in the new row
						// and update the ID and name attributes
						$('input', newRow).each(function(i){
							var newID = newRowNum + '_' + i;
							$(this).attr('id',newID).attr('name', old_names[x++]);
						});
						
						if(x > 0) $('input', newRow).attr({disabled: 'disabled'});
						
						// insert the new row into the table
						// "before" the Add row
						addRow.before(newRow);
												
						// add the remove function to the new row
						$('a.remove', newRow).click(function(){
							$(this).parent().parent().remove();
							$.ajax({   
								type: "POST",
								url: "apagar-anota.php",
								data: "op=apagar&id="+$(this).attr('id')
								/*success: function(response){
									window.location="admin.php?op=editar&cv=";						
								}*/
							});
							return false;				
						});

						 //prevent the default click
						return false;
					});
				});
				
				$('.remove').click(function(){
					$(this).parent().parent().remove();
					$.ajax({   
						type: "POST",
						url: "apagar-anota.php",
						data: "op=apagar&id="+$(this).attr('id')
						/*success: function(response){
							window.location="admin.php?op=editar&cv=";						
						}*/
					});
					
					return false;				
				});
				
    });
</script>

</head>

<?php

if(!is_array($_COOKIE['dinamica']))
{
    $user = base64_decode($_COOKIE['dinamica']);
    $user = addslashes($user);
    $cookie = explode(":", $user);
}

?>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			<div class="inner">
				<h1 id="logo"><a href="#">Dinâmica - Recursos Humanos, Promoções e Marketing</a></h1>
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li class="first">Bem vindo <strong>Admin</strong></li>
						<li><a href="admin.php?op=editar-usuario&id=<?=$cookie[0]?>">Minha conta</a></li>
						<li class="last"><a href="logout.php">Sair</a></li>
					</ul>
					<div id="server_details">
						<dl>
							<dt>Hora:</dt>
							<dd><?php $time = date('h:i:s A'); echo "$time"; ?></dd>
						</dl>
						<dl>
							<dt>Último acesso por:</dt>
							<dd><?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
						</dl>
					</div>
				</div>
				<!--[if !IE]>end user details<![endif]-->
				<?php
				global $op;
				
				if($op == "novo"){
					$novo = "selected";
					$curriculo = "selected";
					$submenu = '<ul>
						<li><a href="admin.php?op=novo" class="'.$novo.'"><span><span>Cadastrar novo curículo</span></span></a></li>
						<li><a href="admin.php?op=lista" class="'.$lista.'"><span><span>Listar todos os currículos</span></span></a></li>
						
					</ul>';
				}elseif($op == "lista"){
					$lista = "selected";
					$curriculo = "selected";
					$submenu = '<ul>
						<li><a href="admin.php?op=novo" class="'.$novo.'"><span><span>Cadastrar novo curículo</span></span></a></li>
						<li><a href="admin.php?op=lista" class="'.$lista.'"><span><span>Listar todos os currículos</span></span></a></li>
						
					</ul>';
				}elseif($op == "lista-negra" || $op == "add-lista"){
					$listaNegra = "selected";
				}elseif($op == "novo-usuario"){
					$usuario = "selected";
					$submenu = '<ul>
						<li><a href="admin.php?op=novo-usuario" class="selected"><span><span>Cadastrar novo usuário</span></span></a></li>
						<li><a href="admin.php?op=lista-usuarios"><span><span>Listar todos os usuários</span></span></a></li>
						
					</ul>';
				}elseif($op == "lista-vagas"){
					$vagas = "selected";
				}
				
				?>
				<!--[if !IE]>start main menu<![endif]-->
				<div id="main_menu">
					<ul>
						<li>
							<a href="admin.php?op=lista" class="<?=$curriculo?>"><span><span>Currículos</span></span></a>
							<?=$submenu?>
						</li>
						<li>
							<a href="admin.php?op=lista-vagas" class="<?=$vagas?>"><span><span>Vagas</span></span></a>
						</li>
						<li>
							<a href="admin.php?op=lista-negra" class="<?=$listaNegra?>"><span><span>Lista negra</span></span></a>
							
						</li>
						
					</ul>
				</div>
				<!--[if !IE]>end main menu<![endif]-->
				
			</div>
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			<!--[if !IE]>start content bottom<![endif]-->
			<div id="content_bottom">
			
			<div class="inner">

				<!--[if !IE]>start info<![endif]-->
				<div id="info">