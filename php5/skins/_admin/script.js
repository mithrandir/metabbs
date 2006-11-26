function $(id) { return document.getElementById(id); }
function editCategory(id, url) {
	$(id).innerHTML = '&rarr; <form method="post" action="' + url + '"><input type="text" name="new_name" size="10" /></form>';
}
