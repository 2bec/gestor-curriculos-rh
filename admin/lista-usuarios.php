<?php

/*
 * função __autoload()
 * carrega uma classe quando ela È necessária,
 * ou seja, quando ela é instancia pela primeira vez.
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


try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR USUARIOS **");

	$criterio = new TCriteria;
	$criterio->add(new TFilter('id', '>', '0' ));
	
	$repositorio = new TRepository("Usuario");
	$usuarios = $repositorio->load($criterio);
	
?>

<!--[if !IE]>start section<![endif]-->
<script type="text/javascript">
	$.cookie("formSalvar", null);
</script>

<div class="section">
<div class="title_wrapper">
	<h2>Lista de Usuários</h2>
	
	<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
	
	<div id="product_list_menu">
		<a href="admin.php?op=novo-usuario" class="update"><span><span><em>Cadastrar novo Usuário</em><strong></strong></span></span></a>
	</div>
	
	
</div>
<!--[if !IE]>start section_inner<![endif]-->
<div class="section_inner">

<div  id="product_list">
	

	<!--[if !IE]>start table_wrapper<![endif]-->
	<div class="table_wrapper">
		<div class="table_wrapper_inner">
		<table cellpadding="0" cellspacing="0" width="100%">
			<thead><tr>
				<th style="text-align:center">ID</th>
				<th style="text-align:center">Permissões</th>
				<th style="width:150px;text-align:center"><a href="#" class="asc">Usuário</a></th>
				<th style="text-align:center"><a href="#">Email</a></th>
				<th style="text-align:center">Opções</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$linha = "first";
			$i = false;
			if($usuarios)
			{
				foreach($usuarios as $usuario)
				{
					if($i){$linha = "second";$i = false;}else{$linha = "first";$i++;}
					echo '<tr class="'.$linha.'">
						<td style="text-align:center">'.$usuario->id.'</td>
						<td style="text-align:center">'.$usuario->permissao.'</td>
						<td style="width:150px;"><a href="admin.php?op=editar-usuario&id='.$usuario->id.'" class="img_name">'.$usuario->login.'</a></td>
						<td><span>'.$usuario->email.'</span></td>
						<td>
							<div class="actions_menu">
								<ul>

									<li><a class="excluir" id ="'.$usuario->id.'" href="admin.php?op=apagar-usuario&id='.$usuario->id.'">Apagar</a></li>
								</ul>
							</div>
						</td>
					</tr>';
				}
			}else{
				echo '<tr colspan="5"><td colspan="5">Nenhum registro encontrado!</td></tr>';
			}


			?>
			
		</tbody></table>
		</div>
	</div>
	<!--[if !IE]>end table_wrapper<![endif]-->
	

</div>
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