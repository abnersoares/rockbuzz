$(document).ready(function(){

	$("input[name='title']").focus();

	$("input[name='title']").keyup(function(){

		var slug = $(this).val().toLowerCase()
								.replace(/ /g,'-')
								.replace(/[^\w-]+/g,'');

		$("input[name='slug']").val( slug );

	});

	$("input[name='tags']").tagsInput({
		'defaultText':'Nova Tag'
	});

	$("input[name='image']").change(function(){
		previewImage(this);
	});

	$("#AddPost").submit(function(){
		savePost();
		return false;
	});

	getAuthors();

});

function previewImage( input ) {

	if (input.files && input.files[0]) {

		var reader = new FileReader();

		reader.onload = function (e) {
			$("#preview").attr("src", e.target.result);
			$("#preview").show();
		}

		reader.readAsDataURL(input.files[0]);

	}

}

function savePost() {

	loading();

	var data = `
		{
			"title": "` + $("input[name='title']").val() + `",
			"body": "` + $("textarea[name='body']").val().replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />') + `",
			"image": "` + $("#preview").attr("src") + `",
			"published": ` + $("input[name='published']:checked").val() + `,
			"author_id": ` + $("select[name='author_id']").val() + `,
			"tags": "` + $("input[name='tags']").val() + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=AddPost',
		data: data,
		success: function ( res ){

			alert('Postagem salva com sucesso!');

			window.location = '?page=PostList';

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


function getAuthors() {

	loading();

	$.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetAuthors',
        data: '',
        success: function ( res ){
            
        	var list = JSON.parse( res );

        	if( list.authors.length > 0 ){

        		for(var i=0; i < list.authors.length; i++){

        			$("select[name='author_id']").append($('<option>', {
					    value: list.authors[i].id,
					    text: list.authors[i].name
					}));

        		}

        	}

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