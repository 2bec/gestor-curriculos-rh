<?php

define("LISTA-NEGRA", true);

try
{
	// Recebe parâmetro de busca (query, q)
	$q = $_GET['q'];
	
    // inicia transação com o banco 'my_gcrh'
    TTransaction::open('my_gcrh');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('log-load.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** LOG LISTAR CURRÍCULOS NA LISTA NEGRA**");

	$criterio = new TCriteria;
	$criterio->add(new TFilter('listaNegra', '!=', 'NULL' ));
	
	$repositorio = new TRepository("Pessoa");
	$pessoas = $repositorio->load($criterio);

	

?>


<!--[if !IE]>start section<![endif]-->
<script type="text/javascript">
	//$.cookie("formSalvar", null);
</script>

<div class="section">
<div class="title_wrapper">
	<h2>Lista Negra</h2>
	
	<div style="float:left;width:100%;height;1px;margin:0;padding:0"></div>
	
	<div id="product_list_menu">
		<a href="admin.php?op=add-lista" class="update"><span><span><em>Adicionar currículo na lista negra</em><strong></strong></span></span></a>
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
				<th style="width:50px;text-align:center">Data Nascimento</th>
				<th style="width:160px;text-align:center">Nome</th>
				<th style="width:80px;text-align:center">CPF</th>
				<th style="width:200px;text-align:center">Texto</th>
				<th style="text-align:center">Opção</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$linha = "first";
			$i = false;
			if($pessoas)
			{
				foreach($pessoas as $pessoa)
				{
					if($i){$linha = "second";$i = false;}else{$linha = "first";$i++;}
					echo '<tr class="'.$linha.'">
						<td style="width:50px;text-align:center">'.$pessoa->dataNascimento.'</td>
						<td style="width:160px;"><a href="admin.php?op=ver&cv='.$pessoa->id.'" class="img_name">'.substr($pessoa->nome,0,98).' ...</a></td>
						<td style="width:80px;text-align:center">'.$pessoa->cpf.'</td>
						<td style="width:200px;text-align:center">'.substr($pessoa->listaNegra,0,120).' ...</td>
						<td>
							<div class="actions">
								<ul>
									<li><a class="listaNegraIco tirar-lista" id ="'.$pessoa->id.'" href="#" style="text-decoration:none;" title="Tirar currículo da lista negra">retirar da lista</a></li>
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
			
			
