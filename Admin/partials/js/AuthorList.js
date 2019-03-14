$(document).ready(function(){

	getAuthors();

});

function getAuthors(){

    loading();

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetAuthors',
        data: '',
        success: function ( res ){
            
            var list = JSON.parse( res );

            authorList( list );

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


function authorList( authors ){

    var list = authors.authors;

    $("table tbody").html('');

    if( list.length > 0 ){

        for( var i=0; i < list.length; i++ ){

            var html = `
            <tr>
                <td>` + list[i].name + `</td>
                <td class="actions">
                    <a href="?page=EditAuthor&id=` + list[i].id + `">[editar]</a>
                    <a href="javascript: removeAuthor(` + list[i].id + `)">[excluir]</a>
                </td>
            </tr>
            `;

            $("table tbody").prepend( html );

        }

    }else
        $("table tbody").html(`
            <tr>
                <td colspan="2">Nenhum autor encontrado.</td>
            </td>
        `);

	loading();

}

function removeAuthor( id ){

    if( confirm('Realmente deseja excluir o autor #' + id + '?') ){

        loading();

        var data = `{"id": "` + id + `"}`;

        $.ajax({
            type: "POST",
            url: BASE_URL + 'Api/?op=RemoveAuthor',
            data: data,
            success: function ( res ){

                loading();

                alert('Autor removido com sucesso!');
                
                getAuthors();

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