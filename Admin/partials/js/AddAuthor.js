$(document).ready(function(){

	$("input[name='name']").focus();

	$("#AddAuthor").submit(function(){
		saveAuthor();
		return false;
	});

});

function saveAuthor() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=AddAuthor',
		data: data,
		success: function ( res ){

			alert('Autor salvo com sucesso!');

			window.location = '?page=AuthorList';

			loading();

		},
		error: function ( res ){

			var message = JSON.parse(res.responseText);
				message = message.message;

			alert( message );

			loading();

		},
		dataType: 'html'
	});

}