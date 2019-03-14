$(document).ready(function(){

	loading();

	var data = `
		{
			"slug": "` + window.location.href.split('slug=')[1].replace('#', '') + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=GetPostBySlug',
		data: data,
		success: function ( res ){

            post( JSON.parse( res ) );

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


});

function getImage( slug, image ){

	if( image != null )
		return '<a href="' + BASE_URL + UPLOADS + '/' + image + '" target="_blank"><img src="' + BASE_URL + UPLOADS + '/' + image + '"></a>';
	else
		return '';

}

function getTags( tags ){

	var tags_html = '';

	if( tags != 'undefinied' ){

		for(var i=0; i < tags.length; i++){

			tags_html += '<a href="#">' + tags[i].name + '</a>';

		}

	}

	return tags_html;

}

function post( post ){

	var tags = post.tag;
	var post = post.post;

	$("#content h1").html( post.title );

	var content = `
		<article class="post">
			` + getImage( post.slug, post.image ) + `
			<p>` + post.body + `</p>
			<p class="by">Por: ` + post.author_name + `</p>
			<h4>Tags:</h4>
			<div class="tags">
				` + getTags( tags ) + `
			</div>
		</article>
	`;

	$("#post").html( content );

}