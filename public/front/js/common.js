function loader(state) {
	if (state) {
		document.getElementById("preloader").style.display = "block";
	} else {
		document.getElementById("preloader").style.display = "none";
	}

}

document.addEventListener('DOMContentLoaded', function () {
	$('#copylink').click(function () {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(this).data('url')).select();
		document.execCommand("copy");
		$temp.remove();
		alert("Link copied to clipboard");
	});
});

$("#forgotForm").on('submit', (function (e) {
	e.preventDefault();
	$.ajax({
		url: route('forgot.password'),
		// url: 'https://newhereits.test/forgot-password',
		type: "POST",
		data: new FormData(this),
		dataType: 'json',
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			loader(true);
		},
		success: function (data) {
			//alert(data);
			// console.log(data);
			if (data.success) {
				$('#forgot_msg').html('<span class="text-success">' + data.message + '</span>');
			} else {
				$('#forgot_msg').html('<span class="text-danger">' + data.message + '</span>');
			}
			var elmnt = document.getElementById("forgot_msg");
			elmnt.scrollIntoView();
			loader(false);
		},
		error: function (e) {
			alert('Somthing Wron');
			console.log(e);
			loader(false);
		}
	});
}));