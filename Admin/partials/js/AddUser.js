$(document).ready(function(){

	$("input[name='name']").focus();

	$("#AddUser").submit(function(){
		saveUser();
		return false;
	});

});

function saveUser() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `",
			"email": "` + $("input[name='email']").val() + `",
			"password": "` + $("input[name='password']").val() + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=AddUser',
		data: data,
		success: function ( res ){

			alert('Usuário salvo com sucesso!');

			window.location = '?page=UserList';

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