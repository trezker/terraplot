function sign_up() {
	$('#signupfeedback').html('Processing...');
	var username = document.getElementById('username').value;
	$.ajax(
	{
		type: 'POST',
		url: '/user/Create_user',
		data: { username: username },
		success: function(data)
		{
			if(ajax_logged_out(data)) return;
			if(!data.success) {
				$('#signupfeedback').html(data.reason);
			} else {
				$('#signupfeedback').html('Redirecting...');
				window.location = '/user';
			}
		}
	});
}

function logout() {
	$('#logout').html('Logging out...');
	$.ajax(
	{
		type: 'GET',
		url: 'user/Logout',
		success: function(data)
		{
			window.location = '/';
		}
	});
}

function delete_openid(id) {
	$.ajax({
		type: 'POST',
		url: '/user/Delete_openid',
		data: { id: id },
		success: function(data) {
			if(ajax_logged_out(data)) return;
			var html = '';
			html += '<div class="login popup_background" id="openid_div">';
			html += '<div class="popup_title">OpenID</div>';
			html += '<div class="login_content">';
			html += data.reason;
			html += '<div class="action" onclick="close_dialog();">OK</div>';
			html += '</div>';
			html += '</div>';
			if(data.success == false) {
				open_dialog(html);
			} else {
				window.location.reload();
			}
		}
	});
}
