$(document).ready(function(){

	$(".search input#search").keyup(function(){
		tableFinder( $(this).val() );
	});

});


function loading(){

	if( $("#loading").is(":visible") ){
		$("#loading").hide();
	}else{
		$("#loading").show();
	}

}


function tableFinder( term ){

	term = term.toUpperCase();

	$("table tbody tr").css("display", "table-row");

	if( term != '' ){

		$(".search div").show();

		$("table tbody tr").each(function(){

			var html   = $(this).html();
			var search = html.split("actions");
				search = search[0].toUpperCase();

			if( search.indexOf( term ) == -1 )
				$(this).css("display", "none");

		});

	}else
		$(".search div").hide();

}

function clearSearch(){

	$(".search input#search").val("");

	tableFinder('');

}