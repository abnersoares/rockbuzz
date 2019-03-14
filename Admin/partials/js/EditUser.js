$(document).ready(function(){

	$("#AddUser").submit(function(){
		saveUser();
		return false;
	});

	getUser();

});

function saveUser() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `",
			"email": "` + $("input[name='email']").val() + `",
			"password": "` + $("input[name='password']").val() + `",
			"id": ` + window.location.href.split('id=')[1].replace(/[^0-9]/g,'') + `
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=EditUser',
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


function getUser() {

	loading();

	var id = window.location.href.split('id=')[1].replace(/[^0-9]/g,'');

	var data = `{ "id": "` + id + `" }`;

	$.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetUser',
        data: data,
        success: function ( res ){
            
        	var res = JSON.parse( res );

        	var tag = res.user;
        	
        	$("input[name='name']").val( tag.name );
        	$("input[name='email']").val( tag.email );

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