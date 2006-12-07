function $(id) { return document.getElementById(id); }
function editCategory(id, url) {
	$(id).innerHTML = '&rarr; <form method="post" action="' + url + '"><input type="text" name="new_name" size="10" /></form>';
}
function confirm(text) {
	p = $('popup');
	p.innerHTML = '<p>' + text + '</p>';
	p.style.display = 'block';
	alert(p.scrollHeight);
	return false;
}
window.onload = function () {
	var el = document.createElement('div');
	el.setAttribute('id', 'popup');
	el.style.display = 'none';
	el.style.position = 'absolute';
	el.style.zIndex = '100';

	document.body.appendChild(el);
}
