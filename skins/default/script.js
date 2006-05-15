function checkForm(form)
{
    elements = form.elements ? form.elements : form;
    valid = true;
    focused = false;
    for (i = 0; i < elements.length; i++) {
        field = elements[i];
        if (!field.tagName) {
            continue;
        }
        if (field.value == '' && field.className != 'ignore') {
            field.className = 'blank';
            if (!focused) {
                field.focus();
                focused = true;
            }
            valid = false;
        } else {
            field.className = (field.className == 'ignore') ? field.className : '';
        }
    }
    return valid;
}

function sendForm(form) {
	if (checkForm(form)) {
		sendingRequest(form);
		return true;
	} else {
		return false;
	}
}

function sendingRequest(form) {
	elements = form.elements ? form.elements : form;
	for (i = 0; i < elements.length; i++) {
		field = elements[i];
		field.readonly = true;
		field.className = 'disabled';
		if (field.type == 'submit') {
			field.disable = true;
			sending = document.getElementById('sending');
			sending.style.display = 'inline';
		}
	}
}

function addFileEntry() {
	upload_list = document.getElementById('uploads');
	list_item = document.createElement("LI");
	file_field = document.createElement("INPUT");
	file_field.type = "file";
	file_field.name = "upload[]";
    file_field.className = "ignore";
	file_field.size = 50;
	list_item.appendChild(file_field);
	upload_list.appendChild(list_item);
}

