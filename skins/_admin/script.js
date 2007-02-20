function editCategory(id, url) {
	$(id).innerHTML = '&rarr; <form method="post" action="' + url + '"><input type="text" name="new_name" size="10" /></form>';
}
function addNewBoard(form) {
	if (!form.name.value) {
		form.name.className = 'empty';
		return false;
	} else {
		form.name.className = '';
	}

	new Ajax.Updater({success: 'boards-body'}, form.action, {
		parameters: Form.serialize(form),
		insertion: Insertion.Bottom,
		onComplete: function () {
			$('add-board-form').reset();
		},
		onFailure: function (transport) {
			alert(transport.responseText);
		}
	});
	return false;
}
