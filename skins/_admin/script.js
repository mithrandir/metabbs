function checkAll(form, status)
{
    for (k in form.elements) {
        if (form.elements[k].className == 'check') {
            form.elements[k].checked = status;
        }
    }
}

var tabs = [];

function $(id) {
	return document.getElementById(id);
}

function setTabDisplay(id, value) {
	$(id).style.display = value;
}

function showTab(id) {
	for (i = 0; i < tabs.length; i++) {
		var tab = tabs[i];
		if (tab == id)
			setTabDisplay(tab, 'block');
		else
			setTabDisplay(tab, 'none');
	}
}

window.onload = function () {
	try {
		links = $('edit-section').getElementsByTagName('a');
	} catch (e) {
		return false;
	}
	for (i = 0; i < links.length; i++) {
		link = links[i];
		link.setAttribute('tab_id', link.href.split('#')[1]);
		tabs.push(link.getAttribute('tab_id'));
		link.onclick = function () {
			showTab(this.getAttribute('tab_id'));
			links = $('edit-section').getElementsByTagName('a');
			for (i = 0; i < links.length; i++) {
				links[i].parentNode.className = '';
			}
			this.parentNode.className = 'selected';
		}
	}
	showTab('general');
}
