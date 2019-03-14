$(document).ready(function(){

	getLogs();

});

function getLogs(){

    loading();

    $.ajax({
        type: "POST",
        url: BASE_URL + 'Api/?op=GetLogs',
        data: '',
        success: function ( res ){
            
            var list = JSON.parse( res );

            logList( list );

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


function logList( logs ){

    var list = logs.logs;

    $("table tbody").html('');

    if( list.length > 0 ){

        for( var i=0; i < list.length; i++ ){

            var data = JSON.stringify(list[i].data);

            if( data == 'null' )
                data = '-';

            var html = `
            <tr>
                <td>` + list[i].date + `</td>
                <td>` + list[i].url + `</td>
                <td><div style="max-width: 200px; overflow-y: auto; line-height: 100px">` + data + `</div></td>
                <td>` + list[i].client_agent + `</td>
                <td>` + list[i].client_ip + `</td>
            </tr>
            `;

            $("table tbody").prepend( html );

        }

    }else
        $("table tbody").html(`
            <tr>
                <td colspan="5">Nenhum log encontrado.</td>
            </td>
        `);

	loading();

}