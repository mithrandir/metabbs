function $(id)
{
    return document.getElementById(id);
}

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
    req.send('ajax=1&' + serialize(form));
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
        return !ajaxPost(form.action, form, function (r) { sendDone(r, id); func(form); });
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

/* document.getElementsBySelector(selector)
	 - returns an array of element objects from the current document
		 matching the CSS selector. Selectors can contain element names, 
		 class names and ids and can be nested. For example:

			 elements = document.getElementsBySelect('div#main p a.external')

		 Will return an array of all 'a' elements with 'external' in their 
		 class attribute that are contained inside 'p' elements that are 
		 contained inside the 'div' element which has id="main"

	 New in version 0.4: Support for CSS2 and CSS3 attribute selectors:
	 See http://www.w3.org/TR/css3-selectors/#attribute-selectors

	 Version 0.4 - Simon Willison, March 25th 2003
	 -- Works in Phoenix 0.5, Mozilla 1.3, Opera 7, Internet Explorer 6, Internet Explorer 5 on Windows
	 -- Opera 7 fails 
*/

function getAllChildren(e) {
	// Returns all children of element. Workaround required for IE5/Windows. Ugh.
	return e.all ? e.all : e.getElementsByTagName('*');
}

document.getElementsBySelector = function(selector) {
	// Attempt to fail gracefully in lesser browsers
	if (!document.getElementsByTagName) {
		return new Array();
	}
	// Split selector in to tokens
	var tokens = selector.split(' ');
	var currentContext = new Array(document);
	for (var i = 0; i < tokens.length; i++) {
		token = tokens[i].replace(/^\s+/,'').replace(/\s+$/,'');;
		if (token.indexOf('#') > -1) {
			// Token is an ID selector
			var bits = token.split('#');
			var tagName = bits[0];
			var id = bits[1];
			var element = document.getElementById(id);
			if (tagName && element.nodeName.toLowerCase() != tagName) {
				// tag with that ID not found, return false
				return new Array();
			}
			// Set currentContext to contain just this element
			currentContext = new Array(element);
			continue; // Skip to next token
		}
		if (token.indexOf('.') > -1) {
			// Token contains a class selector
			var bits = token.split('.');
			var tagName = bits[0];
			var className = bits[1];
			if (!tagName) {
				tagName = '*';
			}
			// Get elements matching tag, filter them for class selector
			var found = new Array;
			var foundCount = 0;
			for (var h = 0; h < currentContext.length; h++) {
				var elements;
				if (tagName == '*') {
						elements = getAllChildren(currentContext[h]);
				} else {
						elements = currentContext[h].getElementsByTagName(tagName);
				}
				for (var j = 0; j < elements.length; j++) {
					found[foundCount++] = elements[j];
				}
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			for (var k = 0; k < found.length; k++) {
				if (found[k].className && found[k].className.match(new RegExp('\\b'+className+'\\b'))) {
					currentContext[currentContextIndex++] = found[k];
				}
			}
			continue; // Skip to next token
		}
		// Code to deal with attribute selectors
		if (token.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/)) {
			var tagName = RegExp.$1;
			var attrName = RegExp.$2;
			var attrOperator = RegExp.$3;
			var attrValue = RegExp.$4;
			if (!tagName) {
				tagName = '*';
			}
			// Grab all of the tagName elements within current context
			var found = new Array;
			var foundCount = 0;
			for (var h = 0; h < currentContext.length; h++) {
				var elements;
				if (tagName == '*') {
						elements = getAllChildren(currentContext[h]);
				} else {
						elements = currentContext[h].getElementsByTagName(tagName);
				}
				for (var j = 0; j < elements.length; j++) {
					found[foundCount++] = elements[j];
				}
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			var checkFunction; // This function will be used to filter the elements
			switch (attrOperator) {
				case '=': // Equality
					checkFunction = function(e) { return (e.getAttribute(attrName) == attrValue); };
					break;
				case '~': // Match one of space seperated words 
					checkFunction = function(e) { return (e.getAttribute(attrName).match(new RegExp('\\b'+attrValue+'\\b'))); };
					break;
				case '|': // Match start with value followed by optional hyphen
					checkFunction = function(e) { return (e.getAttribute(attrName).match(new RegExp('^'+attrValue+'-?'))); };
					break;
				case '^': // Match starts with value
					checkFunction = function(e) { return (e.getAttribute(attrName).indexOf(attrValue) == 0); };
					break;
				case '$': // Match ends with value - fails with "Warning" in Opera 7
					checkFunction = function(e) { return (e.getAttribute(attrName).lastIndexOf(attrValue) == e.getAttribute(attrName).length - attrValue.length); };
					break;
				case '*': // Match ends with value
					checkFunction = function(e) { return (e.getAttribute(attrName).indexOf(attrValue) > -1); };
					break;
				default :
					// Just test for existence of attribute
					checkFunction = function(e) { return e.getAttribute(attrName); };
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			for (var k = 0; k < found.length; k++) {
				if (checkFunction(found[k])) {
					currentContext[currentContextIndex++] = found[k];
				}
			}
			// alert('Attribute Selector: '+tagName+' '+attrName+' '+attrOperator+' '+attrValue);
			continue; // Skip to next token
		}
		// If we get here, token is JUST an element (not a class or ID selector)
		tagName = token;
		var found = new Array;
		var foundCount = 0;
		for (var h = 0; h < currentContext.length; h++) {
			var elements = currentContext[h].getElementsByTagName(tagName);
			for (var j = 0; j < elements.length; j++) {
				found[foundCount++] = elements[j];
			}
		}
		currentContext = found;
	}
	return currentContext;
}



/* That revolting regular expression explained 
/^(\w+)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/
	\---/	\---/\-------------/		\-------/
		|			|				 |							 |
		|			|				 |					 The value
		|			|		~,|,^,$,* or =
		|	 Attribute 
	 Tag
*/

function highlight(id, keyword)
{
    el_list = document.getElementsBySelector(id);
    len = el_list.length;
    for (i = 0; i < len; i++) {
        el = el_list[i];
        el.innerHTML = el.innerHTML.replace(new RegExp("("+keyword+")", "gi"), "<span class=\"highlight\">$1</span>");
    }
}
