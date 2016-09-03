<?php


$op = $_REQUEST[op];

include("header.php");

switch($op)
{
 	case "novo":
		include("novo-cv.php");
		break;;
	case "lista":
		include("lista-cv.php");
		break;;
	case "lista-negra":
		include("lista-negra.php");
		break;;
	case "editar":
		include("editar-cv.php");
		break;;
	case "ver":
		include("ver-cv.php");
		break;;
	case "apagar":
		include("apagar-cv.php");
		break;;
	case "novo-usuario":
		//include("novo-usuario.php");
		break;;
	case "editar-usuario":
		include("editar-usuario.php");
		break;;
	case "lista-vagas":
		include("lista-vagas.php");
		break;;
	case "nova-vaga":
		include("nova-vaga.php");
		break;;
	case "editar-vaga":
		include("editar-vaga.php");
		break;;
	case "apagar-vaga":
		include("apagar-vaga.php");
		break;;
	case "add-lista":
		include("add-lista.php");
		break;;
	case "enviar-email":
		include("enviar-email.php");
		break;;
	default:
		break;;
}

include("sidebar.php");

?>

<?php

include("footer.php");

?>
