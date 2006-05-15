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


function fadeIn(el, opacity) {
    if (!opacity) opacity = 0;
    if (opacity < 1) {
        opacity += 0.05;
        setOpacity(el, opacity);
        window.setTimeout(function () { fadeIn(el, opacity) }, 50);
    }
}
function setOpacity(el, opacity) {
    el.style.opacity = opacity;
    el.style.filter = "alpha(opacity="+(opacity*100)+")";
}

function ajaxPost(url, form, func) {
    if (window.XMLHttpRequest) {
        try {
            req = new XMLHttpRequest();
        } catch (e) {
            return false;
        }
    } else if (window.ActiveXObject) {
        try {
            req = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            try {
                req = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (e) {
                return false;
            }
        }
    }
    req.open("POST", url, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(serialize(form));
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            func(req);
        }
    }
    return true;
}
function serialize(form) {
    body = new Array;
    elements = form.elements?form.elements:form;
    for (i = 0; i < elements.length; i++) {
        el = elements[i];
        if (el.name) {
            body.push(encodeURIComponent(el.name) + "=" + encodeURIComponent(el.value));
        }
    }
    return body.join('&');
}

function sendDone(r, id) {
    el = document.getElementById(id);
    el.innerHTML += r.responseText;
    items = el.getElementsByTagName('LI');
    sendingDone();
    fadeIn(items[items.length - 1]);
}

function sendForm(form, id, func) {
    if (!func) {
        func = function () {}
    }
    if (checkForm(form)) {
        sendingRequest();
        return !ajaxPost(form.action + '?ajax=1', form, function (r) { sendDone(r, id); func(form); });
    } else {
        return false;
    }
}

function sendingRequest() {
    el = document.getElementById('sending');
    el.style.display = 'inline';
}

function sendingDone() {
    el = document.getElementById('sending');
    el.style.display = 'none';
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

