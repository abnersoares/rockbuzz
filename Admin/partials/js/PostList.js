$(document).ready(function(){

	getPosts();

});

function getPosts(){

    loading();

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetPosts',
        data: '',
        success: function ( res ){
            
            var list = JSON.parse( res );

            postList( list );

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

function getImage( image ){
    if( image != '' && image != null )
        return '<a href="' + BASE_URL + UPLOADS + '/' + image + '" target="_blank"><img src="' + BASE_URL + UPLOADS + '/' + image + '" class="thumb" /></a>';
    else
        return '-';
}

function publishedSpan( published ){
    return published == 1 ? '<span class="published">SIM</span>' : '<span class="published not">NÃO</span>';
}

function getActions( id, published = null ){

    var actions = `<a href="?page=EditPost&id=` + id + `">[editar]</a>
                  <a href="javascript: removePost(` + id + `)">[excluir]</a>`;

    if( published == true )
        actions += '<a href="javascript: enableDisablePost(' + id + ', \'disable\')">[desativar]</a>';
    else
        actions += '<a href="javascript: enableDisablePost(' + id + ', \'enable\')">[ativar]</a>';

    return actions;

}

function getBody( body ){

    body = body.replace(/<br \/>/g, " ");

    if( body.length > 35 )
        return body.substr(0, 35) + ' ...';
    else
        return body;

}

function postList( posts ){

    var list = posts.posts;

    $("table tbody").html('');

    if( list.length > 0 ){

        for( var i=0; i < list.length; i++ ){

            var html = `
            <tr>
                <td>` + list[i].title + `</td>
                <td>` + list[i].slug + `</td>
                <td>` + getBody( list[i].body ) + `</td>
                <td>` + getImage( list[i].image ) + `</td>
                <td>` + publishedSpan( list[i].published ) + `</td>
                <td>` + list[i].author_name + `</td>
                <td class="actions">
                    ` + getActions( list[i].id, list[i].published ) + `
                </td>
            </tr>
            `;

            $("table tbody").prepend( html );

        }

    }else
        $("table tbody").html(`
            <tr>
                <td colspan="7">Nenhuma postagem encontrada.</td>
            </td>
        `);

	loading();

}

function removePost( id ){

    if( confirm('Realmente deseja excluir o post #' + id + '?') ){

        loading();

        var data = `{"id": "` + id + `"}`;

        $.ajax({
            type: "POST",
            url: BASE_URL + 'Api/?op=RemovePost',
            data: data,
            success: function ( res ){

                loading();

                alert('Postagem removida com sucesso!');
                
                getPosts();

            },
            error: function ( res ){

                var message = JSON.parse(res.responseText);
                    message = message.message;

                alert( message );

                loading();
                
            },
            dataType: 'html'
        });

    }else
        return false;

}


function enableDisablePost( id, action ){


    loading();

    var data = `{"id": "` + id + `", "action": "` + action + `"}`;

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=EnableDisablePost',
        data: data,
        success: function ( res ){

            loading();

            getPosts();

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