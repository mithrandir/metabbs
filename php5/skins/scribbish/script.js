function $(id)
{
    return document.getElementById(id);
}

function addFileEntry() {
    upload_list = $('uploads');
    list_item = document.createElement("LI");
    file_field = document.createElement("INPUT");
    file_field.type = "file";
    file_field.name = "upload[]";
    file_field.className = "ignore";
    file_field.size = 50;
    list_item.appendChild(file_field);
    upload_list.appendChild(list_item);
}
