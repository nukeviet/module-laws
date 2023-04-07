/* *
 * @Project NUKEVIET 4.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Wed, 27 Jul 2011 14:55:22 GMT
 */

function nv_add_files(nv_admin_baseurl, nv_files_dir, nv_lang_delete, nv_lang_select) {
    nv_num_files++;
    $('#filearea').append('<div id="fileitem_' + nv_num_files + '" style="margin-bottom: 5px">' + '<input class="form-control pull-left w400" style="margin: 4px 4px 0 0;" type="text" name="files[]" id="fileupload_' + nv_num_files + '" value="" />' + '<input onclick="nv_open_browse( \'' + nv_admin_baseurl + 'index.php?' + nv_name_variable + '=upload&popup=1&area=fileupload_' + nv_num_files + '&path=' + nv_files_dir + '&type=file\', \'NVImg\', \'850\', \'500\', \'resizable=no,scrollbars=no,toolbar=no,location=no,status=no\' );return false;" type="button" value="Browse server" class="selectfile btn btn-primary" style="margin-right: 3px" />' + '<input onclick="nv_delete_datacontent(\'fileitem_' + nv_num_files + '\');return false;" type="button" value="' + nv_lang_delete + '" class="selectfile btn btn-danger" />' + '</div>');

    return false;
}

function nv_delete_datacontent(content) {
    $('#' + content).remove();
    return false;
}

function nv_change_status(id) {
    var nv_timer = nv_settimeout_disable('change_status' + id, 4000);
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(), 'changestatus=1&id=' + id, function(res) {
        if (res != 'OK') {
            alert(nv_is_change_act_confirm[2]);
            location.reload();
        }
        return;
    });
    return;
}

function nv_delete_law(id) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(), 'del=1&id=' + id, function(res) {
            if (res == 'OK') {
                location.reload();
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}

function nv_delete_signer(id) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=signer&nocache=' + new Date().getTime(), 'del=1&id=' + id, function(res) {
            if (res == 'OK') {
                location.reload();
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}

function nv_chang_cat(catid, mod) {
    var nv_timer = nv_settimeout_disable('id_' + mod + '_' + catid, 5000);
    var new_vid = $('#id_' + mod + '_' + catid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_cat&nocache=' + new Date().getTime(), 'catid=' + catid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
        if (res != 'OK') {
            alert(nv_is_change_act_confirm[2]);
        }
        clearTimeout(nv_timer);
        location.reload();
        return;
    });
    return;
}

// Xử lý các select tool tại trang danh sách văn bản
function nv_main_action(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        var action = document.getElementById('action-of-main').value;
        if (action == 'delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.post(
                    script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(),
                    'del=1&listid=' + listid, function(res) {
                    if (res == 'OK') {
                        location.reload();
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                });
            }
        }
    } else {
        alert(msgnocheck);
    }
}

// Xử lý các select tool tại trang danh sách người kí
function nv_signer_action(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        var action = document.getElementById('action-of-signer').value;
        if (action == 'delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.post(
                    script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=signer&nocache=' + new Date().getTime(),
                    'del=1&listid=' + listid, function(res) {
                    if (res == 'OK') {
                        location.reload();
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                });
            }
        }
    } else {
        alert(msgnocheck);
    }
}

// Xử lý các select tool tại trang danh sách lĩnh vực
function nv_area_action(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        var action = document.getElementById('action-of-list').value;
        if (action == 'delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.post(
                    script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=area&nocache=' + new Date().getTime(),
                    'del=0&listid=' + listid, function(res) {
                    if (res != 'OK') {
                        alert(res);
                    }
                    location.reload();
                });
            }
        }
    } else {
        alert(msgnocheck);
    }
}

// Xử lý các select tool tại trang danh sách thể loại
function nv_cat_action(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        var action = document.getElementById('action-of-list').value;
        if (action == 'delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.post(
                    script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(),
                    'del=0&listid=' + listid, function(res) {
                    if (res != 'OK') {
                        alert(res);
                    }
                    location.reload();
                });
            }
        }
    } else {
        alert(msgnocheck);
    }
}

// Xử lý các select tool tại trang danh sách cơ quan ban hành
function nv_subject_action(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        var action = document.getElementById('action-of-list').value;
        if (action == 'delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.post(
                    script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=subject&nocache=' + new Date().getTime(),
                    'del=0&listid=' + listid, function(res) {
                    if (res != 'OK') {
                        alert(res);
                    }
                    location.reload();
                });
            }
        }
    } else {
        alert(msgnocheck);
    }
}
