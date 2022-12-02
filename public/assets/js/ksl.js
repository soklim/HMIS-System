function GetDistrict(_parent_id, element_id) {
    $.post('/Customers/GetDistrict', {
        parent_id: _parent_id
    }, function (result) {
        var dataList = result.dataList;
        $("#" + element_id).find('option').not(':first').remove();
        $('#' + element_id).select2({ data: dataList, width: '100%' });
    });
}

function GetDistrict_Dialog(_parent_id, element_id, dialog_name) {
    $.post('/Customers/GetDistrict', {
        parent_id: _parent_id,
    }, function (result) {
        var dataList = result.dataList;
        $("#" + element_id).find('option').not(':first').remove();
        $('#' + element_id).select2({ data: dataList, width: '100%', dropdownParent: $("#" + dialog_name) });
    });
}
function GetCommune(_parent_id, element_id) {
    $.post('/Customers/GetCommune', {
        parent_id: _parent_id
    }, function (result) {
        var dataList = result.dataList;
        $("#" + element_id).find('option').not(':first').remove();
        $('#' + element_id).select2({ data: dataList, width: '100%' });
    });
}

function GetCommune_Dialog(_parent_id, element_id, dialog_name) {
    $.post('/Customers/GetCommune', {
        parent_id: _parent_id
    }, function (result) {
        var dataList = result.dataList;
        $("#" + element_id).find('option').not(':first').remove();
        $('#' + element_id).select2({ data: dataList, width: '100%', dropdownParent: $("#" + dialog_name) });
    });
}
function GetVillage(_parent_id, element_id) {
    $.post('/Customers/GetVillage', {
        parent_id: _parent_id
    }, function (result) {
        var dataList = result.dataList;
        $('#' + element_id).select2({ data: dataList, width: '100%' });
    });
}

function GetVillage_Dialog(_parent_id, element_id, dialog_name) {
    $.post('/Customers/GetVillage', {
        parent_id: _parent_id
    }, function (result) {
        var dataList = result.dataList;
        $("#" + element_id).find('option').not(':first').remove();
        $('#' + element_id).select2({ data: dataList, width: '100%', dropdownParent: $("#" + dialog_name) });
    });
}