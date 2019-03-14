$(document).ready(function(){

	$("#AddAuthor").submit(function(){
		saveAuthor();
		return false;
	});

	getAuthor();

});

function saveAuthor() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `",
			"id": ` + window.location.href.split('id=')[1].replace(/[^0-9]/g,'') + `
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=EditAuthor',
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


function getAuthor() {

	loading();

	var id = window.location.href.split('id=')[1].replace(/[^0-9]/g,'');

	var data = `{ "id": "` + id + `" }`;

	$.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetAuthor',
        data: data,
        success: function ( res ){
            
        	var res = JSON.parse( res );

        	var author = res.author;
        	
        	$("input[name='name']").val( author.name );

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