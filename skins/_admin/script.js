function checkAll(form, status)
{
    for (k in form.elements) {
        if (form.elements[k].className == 'check') {
            form.elements[k].checked = status;
        }
    }
}
