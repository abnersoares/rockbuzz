$(document).ready(function(){

	getTags();

});

function getTags(){

    loading();

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetTags',
        data: '',
        success: function ( res ){
            
            var list = JSON.parse( res );

            tagList( list );

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


function tagList( tags ){

    var list = tags.tags;

    $("table tbody").html('');

    if( list.length > 0 ){

        for( var i=0; i < list.length; i++ ){

            var html = `
            <tr>
                <td>` + list[i].name + `</td>
                <td class="actions">
                    <a href="?page=EditTag&id=` + list[i].id + `">[editar]</a>
                    <a href="javascript: removeTag(` + list[i].id + `)">[excluir]</a>
                </td>
            </tr>
            `;

            $("table tbody").prepend( html );

        }

    }else
        $("table tbody").html(`
            <tr>
                <td colspan="2">Nenhuma tag encontrada.</td>
            </td>
        `);

	loading();

}

function removeTag( id ){

    if( confirm('Realmente deseja excluir a tag #' + id + '?') ){

        loading();

        var data = `{"id": "` + id + `"}`;

        $.ajax({
            type: "POST",
            url: BASE_URL + 'Api/?op=RemoveTag',
            data: data,
            success: function ( res ){

                loading();

                alert('Tag removida com sucesso!');
                
                getTags();

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