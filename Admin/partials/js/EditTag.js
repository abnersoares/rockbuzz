$(document).ready(function(){

	$("#AddTag").submit(function(){
		saveTag();
		return false;
	});

	getTag();

});

function saveTag() {

	loading();

	var data = `
		{
			"name": "` + $("input[name='name']").val() + `",
			"id": ` + window.location.href.split('id=')[1].replace(/[^0-9]/g,'') + `
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=EditTag',
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


function getTag() {

	loading();

	var id = window.location.href.split('id=')[1].replace(/[^0-9]/g,'');

	var data = `{ "id": "` + id + `" }`;

	$.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetTag',
        data: data,
        success: function ( res ){
            
        	var res = JSON.parse( res );

        	var tag = res.tag;
        	
        	$("input[name='name']").val( tag.name );

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