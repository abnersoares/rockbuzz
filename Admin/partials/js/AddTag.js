$(document).ready(function(){

	$("input[name='name']").focus();

	$("#AddTag").submit(function(){
		saveTag();
		return false;
	});

});

function saveTag() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=AddTag',
		data: data,
		success: function ( res ){

			alert('Tag salva com sucesso!');

			window.location = '?page=TagList';

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