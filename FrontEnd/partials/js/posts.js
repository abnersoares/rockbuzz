$(document).ready(function(){

	loading();

	var data = `{ "published": 1 }`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=GetPosts',
		data: data,
		success: function ( res ){

			var list = JSON.parse( res );

            postList( list );

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


	$("input[name='search']").keyup(function(){
		search( $(this).val() );
	});

});

function getImage( slug, image ){

	if( image != null )
		return '<a href="?slug=' + slug + '"><img src="' + BASE_URL + UPLOADS + '/' + image + '"></a>';
	else
		return '';

}

function getBody( body ){

    body = body.replace(/<br \/>/g, " ");

    if( body.length > 200 )
        return body.substr(0, 200) + ' ...';
    else
        return body;

}

function postList( posts ){

	var list = posts.posts;

	$("#posts").html("");

	if( list.length > 0 ){

		for(var i=0; i < list.length; i++){

			var content = `
				<article>
					<h2><a href="?slug=` + list[i].slug + `">` + list[i].title + `</a></h2>
					` + getImage( list[i].slug, list[i].image ) + `
					<p>` + getBody( list[i].body ) + `</p>
					<p class="by">Por: ` + list[i].author_name + `</p>
					<div>
						<a href="?slug=` + list[i].slug + `"><button>Ver Postagem</button></a>
					</div>
				</article>
			`;

			$("#posts").prepend( content );

		}

	}else
		$("#posts").html("Nenhum post encontrado.");

}

function search( term ){

	term = term.toUpperCase();

	$("#posts article").css("display", "inline-block");

	$("#posts article").each(function(){

		var title = $(this).find('h2 a').html().toUpperCase();
		var body  = $(this).find('p').html().toUpperCase();
		var by    = $(this).find('p.by').html().toUpperCase().replace('POR: ');

		if( title.indexOf(term) == -1 && body.indexOf(term) == -1 && by.indexOf(term) == -1 )
			$(this).css("display", "none");

	});

}