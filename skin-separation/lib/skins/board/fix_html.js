function fixHTML()
{
	elements = document.getElementsByTagName('DIV');
	for (i = 0; i < elements.length; i++) {
		el = elements[i];
		if (el.className == 'content') {
			el.innerHTML = el.firstChild.textContent;
		}
	}
}
window.onload = function ()
{
	if (navigator.userAgent.indexOf("Gecko") != -1) {
		fixHTML();
	}
}
