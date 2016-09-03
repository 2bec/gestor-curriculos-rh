<?php



try
{
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR VAGAS **");

	$criterio = new TCriteria;
	$criterio->add(new TFilter('id', '>', '0' ));
	
	$repositorio = new TRepository("Vaga");
	$vagas = $repositorio->load($criterio);
	
?>

<!--[if !IE]>start section<![endif]-->
<script type="text/javascript">
	//$.cookie("formSalvar", null);
</script>

<div class="section">
<div class="title_wrapper">
	<h2>Lista de Vagas</h2>
	
	<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
	
	<div id="product_list_menu">
		<a href="admin.php?op=nova-vaga" class="update"><span><span><em>Cadastrar nova vaga</em><strong></strong></span></span></a>
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
				<th style="width:50px;text-align:center">Data</th>
				<th style="width:450px;text-align:center">Titulo</th>
				<th style="text-align:center">Opções</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$linha = "first";
			$i = false;
			if($vagas)
			{
				foreach($vagas as $vaga)
				{
					if($i){$linha = "second";$i = false;}else{$linha = "first";$i++;}
					if($vaga->ativo == "s"){$class = "vaga-ativa";$tituloLink="Vaga ativa! Clique para desativar.";}else{$class = "vaga-desativa";$tituloLink="Vaga desativada! Clique para ativar.";}
					echo '<tr class="'.$linha.'">
						<td style="text-align:center">'.$vaga->dataCadastro.'</td>
						<td style="width:150px;"><a href="admin.php?op=editar-vaga&id='.$vaga->id.'" class="img_name">'.substr($vaga->titulo,0,148).' ...</a></td>
						<td>
							<div class="actions">
								<ul>
									<li><a class="anotacoesIco" href="admin.php?op=editar-vaga&id='.$vaga->id.'" title="Editar">editar</a></li>
									<li><a class="excluirIco delete-vaga" id ="'.$vaga->id.'" href="admin.php?op=apagar-vaga&id='.$vaga->id.'" title="Exluir vaga">apagar</a></li>
									<li><a class="'.$class.'" id ="'.$vaga->id.'" href="#" style="text-decoration:none;" title="'.$tituloLink.'">'.$vaga->ativo.'</a></li>
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