
$(document).ready(function(){
$(".buscar").click(function(){
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var estado = $("#estado").val();
	var cidade = $("#cidade").val();
	var idade = $("#idade").val();
	var sexo = $("#sexo").val();
	var estadoCivil = $("#estadoCivil").val();
	var habilitacao = $("#habilitacao").val();
	var funcao = $("#funcaoCargo").val();
	var experiencia = $("#experiencia").val();
	var pagenum = $(this).attr("href");
	$.ajax({
		type: "POST",
		url: "buscar.php",
		data: "nome="+nome+"&cpf="+cpf+"&estado="+estado+"&cidade="+cidade+"&idade="+idade+"&sexo="+sexo+"&estadoCivil="+estadoCivil+"&habilitacao="+habilitacao+"&funcaoCargo="+funcao+"&experiencia="+experiencia+"&pagenum="+pagenum+"",
		beforeSend: function(){
			$("#muda").html("Buscando ...");
		},
		success: function(response){
			$("#muda").html(response);
			
			// Mostra janela de confirmação LINK
			$('.delete').click(function(){
				var result = confirm("Deseja realmente excluir esse registro? *Essa ação não poderá ser desfeita!");
				if(result == true){
					$.ajax({   
						type: "POST",
						url: "apagar-cv.php",
						data: "cv="+$(this).attr("id"),
						success: function(response){
							alert(response);
							window.location="admin.php?op=lista";						
						}
					})
				}
				return false;
			});
			
		}
	})
	return false;
});
});