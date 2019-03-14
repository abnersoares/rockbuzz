$(document).ready(function(){

	$("input[name='email']").focus();

	$("#Login").submit(function(){
		login();
		return false;
	});

});


function invalidPassword(){

	$(".error").css("visibility", "visible");

	var fields = $("input[name='email'], input[name='password']");
	var time   = 100;

	fields.animate({ marginLeft: "+=50" }, time);
	fields.animate({ marginLeft: "-=50" }, time);

	fields.animate({ marginLeft: "+=50" }, time);
	fields.animate({ marginLeft: "-=50" }, time);

	$("input[name='email']").focus();

}

function login() {

	loading();

	var data = `
		{
			"email": "` + $("input[name='email']").val() + `",
			"password": "` + $("input[name='password']").val() + `"
		}
	`;

	$.ajax({
		type: "POST",
		url: BASE_URL + 'Api/?op=Login',
		data: data,
		success: function ( res ){

			window.location = './?page=PostList';

			loading();

		},
		error: function ( res ){

			loading();

			invalidPassword();

		},
		dataType: 'html'
	});

}