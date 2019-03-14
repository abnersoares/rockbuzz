$(document).ready(function(){

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

	getPost();

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
			"tags": "` + $("input[name='tags']").val() + `",
			"id": ` + window.location.href.split('id=')[1].replace(/[^0-9]/g,'') + `
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=EditPost',
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
        async: false,
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


function getPost() {

	loading();

	var id = window.location.href.split('id=')[1].replace(/[^0-9]/g,'');

	var data = `{ "id": "` + id + `" }`;

	$.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetPost',
        data: data,
        success: function ( res ){
            
        	var res = JSON.parse( res );

        	var post = res.post;
        	var tags = res.tag;
        	
        	$("input[name='title']").val( post.title );
        	$("input[name='slug']").val( post.slug );
        	$("textarea[name='body']").val( post.body.replace(/<br \/>/g, "\n") );
        	$("select[name='author_id']").val( post.author_id );

        	if( post.published == 0 )
        		$("input[name='published'][value='0']").prop("checked", true);

        	if( post.image != '' && post.image != null ){
        		$("#preview").attr("src", BASE_URL + UPLOADS + '/' + post.image);
        		$("#preview").show();
        	}

        	if( tags.length > 0 ){
        		
        		var tag_string = '';
        		
        		for(var i=0; i < tags.length; i++)
        			tag_string += tags[i].name + ",";

        		tag_string = tag_string.substr(0, tag_string.length-1);

        		$("input[name='tags']").importTags( tag_string );

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