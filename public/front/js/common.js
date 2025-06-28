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

// for common search
let searchRequest = null;

function search(search) {
	// Abort previous request if still pending
	if (searchRequest !== null) {
		searchRequest.abort();
	}

	// Store the new request
	searchRequest = $.ajax({
		url: route('search'),
		method: "get",
		data: {
			search: search
		},
		beforeSend: function () {
			$('#search-result').html("<li><label class='w-100 ' tabindex='2'> <p class='location-name border-bottom-0 text-center'>Searching ...</p></label></li>");
		},
		success: function (res) {
			$('#search-result').html(res.data);
		},
		error: function (e) {
			if (e.statusText !== 'abort') { // Ignore abort errors
				alert('Something went wrong');
				console.log(e);
			}
		}
	});
}
