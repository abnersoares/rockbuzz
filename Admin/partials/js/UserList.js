$(document).ready(function(){

	getUsers();

});

function getUsers(){

    loading();

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetUsers',
        data: '',
        success: function ( res ){
            
            var list = JSON.parse( res );

            userList( list );

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


function userList( users ){

    var list = users.users;

    $("table tbody").html('');

    if( list.length > 0 ){

        for( var i=0; i < list.length; i++ ){

            var html = `
            <tr>
                <td>` + list[i].name + `</td>
                <td>` + list[i].email + `</td>
                <td class="actions">
                    <a href="?page=EditUser&id=` + list[i].id + `">[editar]</a>
                    <a href="javascript: removeUser(` + list[i].id + `)">[excluir]</a>
                </td>
            </tr>
            `;

            $("table tbody").prepend( html );

        }

    }else
        $("table tbody").html(`
            <tr>
                <td colspan="2">Nenhum usuário encontrado.</td>
            </td>
        `);

	loading();

}

function removeUser( id ){

    if( confirm('Realmente deseja excluir o usuário #' + id + '?') ){

        loading();

        var data = `{"id": "` + id + `"}`;

        $.ajax({
            type: "POST",
            url: BASE_URL + 'Api/?op=RemoveUser',
            data: data,
            success: function ( res ){

                loading();

                alert('Usuário removido com sucesso!');
                
                getUsers();

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