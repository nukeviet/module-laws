<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 27 Jul 2011 14:55:22 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

use NukeViet\Module\laws\Shared\Admins;

$contents = '';
$groups_list = nv_groups_list();
$catList = nv_catList();
list($sList, $sListAdd) = nv_sList();
$eList = nv_eList();
$sgList = nv_sgList();

$row = $post = $error = [];
$post['id'] = $nv_Request->get_int('id', 'get', 0);

if ($post['id'] > 0) {
    // Lấy và kiểm tra quyền sửa văn bản
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id=" . $post['id'];
    $result = $db->query($sql);
    $row = $result->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main");
    }

    $row['area_ids'] = empty($row['area_ids']) ? [] : explode(',', $row['area_ids']);
    $edit = false;
    if (ADMIN_TYPE == Admins::TYPE_ADMIN) {
        $edit = true;
    } elseif (ADMIN_TYPE == Admins::TYPE_AREA) {
        $edit = !empty(array_intersect($row['area_ids'], $allowed_area_edit));
    } elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
        $edit = (!empty($array_subject_admin[$admin_id][$row['sid']]['admin']) or !empty($array_subject_admin[$admin_id][$row['sid']]['edit_content']));
    }
    if (!$edit) {
        nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main");
    }

    $row['area_id_old'] = $row['area_id'] = $row['area_ids'];
    $post = $row;

    $post['ptitle'] = $nv_Lang->getModule('editRow');
    $post['action_url'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $post['id'];
} else {
    // Kiểm tra quyền thêm văn bản
    if (ADMIN_TYPE != Admins::TYPE_ADMIN and (empty($sListAdd) or empty($allowed_area_add))) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    }

    $post['area_id_old'] = $post['area_id'] = [];
    $post['publtime'] = NV_CURRENTTIME;
    $post['exptime'] = 0;
    $post['relatement'] = $post['replacement'] = $post['title'] = $post['code'] = $post['introtext'] = $post['bodytext'] = $post['keywords'] = $post['author'] = '';
    $post['groups_view'] = $post['groups_download'] = '6';
    $post['cid'] = $post['sid'] = $post['sgid'] = $post['eid'] = $post['who_view'] = $post['who_download'] = 0;

    $post['groupcss'] = $post['groupcss2'] = "groupcss0";
    $post['files'] = '';

    $post['start_comm_time'] = 0;
    $post['end_comm_time'] = 0;
    $post['startvalid'] = 0;
    $post['approval'] = 0;

    $post['ptitle'] = $nv_Lang->getModule('addRow');
    $post['action_url'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content";
}

$page_title = $post['ptitle'];

if ($nv_Request->isset_request('save', 'post')) {
    $post['title'] = nv_substr($nv_Request->get_title('title', 'post', ''), 0, 250);
    if (empty($post['title'])) {
        $error[] = $nv_Lang->getModule('errorIsEmpty') . ": " . $nv_Lang->getModule('title');
    }

    $post['cid'] = $nv_Request->get_int('cid', 'post', 0);
    if (!isset($catList[$post['cid']])) {
        $error[] = $nv_Lang->getModule('erroNotSelectCat');
    }

    $post['area_id'] = $nv_Request->get_typed_array('aid', 'post', 'int', []);

    /*
     * Xử lý quyền đới với cơ quan ban hành
     */
    if (empty($post['id'])) {
        // Khi thêm văn bản, đơn giản chỉ lấy các cơ quan ban hành được phép
        $post['area_id'] = array_intersect($post['area_id'], $allowed_area_add);
    } else {
        // Khi sửa văn bản lấy ra các cơ quan cũ mà mình không được phép sửa
        $area_id_notallowed = array_values(array_diff($post['area_id_old'], $allowed_area_edit));
        // Đối với dữ liệu submit lên chỉ lấy các cơ quan được phép sửa
        $post['area_id'] = array_values(array_intersect($post['area_id'], $allowed_area_edit));
        // Gộp 2 dữ liệu này lại
        if (!empty($area_id_notallowed)) {
            $post['area_id'] = array_filter(array_unique(array_merge($post['area_id'], $area_id_notallowed)));
        }
    }

    if (empty($post['area_id'])) {
        $error[] = $nv_Lang->getModule('erroNotSelectArea');
    }

    $post['sid'] = $nv_Request->get_int('sid', 'post', 0);
    if (!isset($sList[$post['sid']])) {
        $error[] = $nv_Lang->getModule('erroNotSelectSubject');
    }

    $post['eid'] = $nv_Request->get_int('eid', 'post', 0);
    $post['introtext'] = $nv_Request->get_title('introtext', 'post', '', 1);
    $post['introtext'] = nv_nl2br($post['introtext'], "<br />");
    if (empty($post['introtext'])) {
        $error[] = $nv_Lang->getModule('errorIsEmpty') . ": " . $nv_Lang->getModule('introtext');
    }

    $post['note'] = $nv_Request->get_title('note', 'post', '', 1);
    $post['note'] = nv_nl2br($post['note'], "<br />");

    $post['replacement'] = nv_substr($nv_Request->get_title('replacement', 'post', '', 1), 0, 255);

    if (!empty($post['replacement'])) {
        $check_replacement = explode(",", $post['replacement']);
        $check_replacement = array_map("trim", $check_replacement);
        $check_replacement = array_map("intval", $check_replacement);
        $check_replacement = array_filter($check_replacement);

        $error_sub = [];
        foreach ($check_replacement as $replacement) {
            $sql = "SELECT COUNT(*) as count FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id=" . $replacement;
            $result = $db->query($sql);
            $count = $result->fetchColumn();

            if ($count != 1) {
                $error_sub[] = sprintf($nv_Lang->getModule('replacementError'), $replacement);
            }
        }

        if (empty($error_sub)) {
            $post['replacement'] = implode(",", $check_replacement);
        } else {
            $error = array_merge($error, $error_sub);
        }
    }

    $post['relatement'] = nv_substr($nv_Request->get_title('relatement', 'post', '', 1), 0, 255);

    if (!empty($post['relatement'])) {
        $check_relatement = explode(",", $post['relatement']);
        $check_relatement = array_map("trim", $check_relatement);
        $check_relatement = array_map("intval", $check_relatement);
        $check_relatement = array_filter($check_relatement);

        $error_sub = [];
        foreach ($check_relatement as $relatement) {
            $sql = "SELECT COUNT(*) as count FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id=" . $relatement;
            $result = $db->query($sql);
            $count = $result->fetchColumn();

            if ($count != 1) {
                $error_sub[] = sprintf($nv_Lang->getModule('relatementError'), $relatement);
            }
        }

        if (empty($error_sub)) {
            $post['relatement'] = implode(",", $check_relatement);
        } else {
            $error = array_merge($error, $error_sub);
        }
    }

    $alias = change_alias($post['title']);
    $post['code'] = nv_substr($nv_Request->get_title('code', 'post', '', 1), 0, 50);
    $post['bodytext'] = nv_editor_nl2br($nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS));
    $post['keywords'] = $nv_Request->get_title('keywords', 'post', '', 1);
    if (!empty($post['keywords'])) {
        $post['keywords'] = explode(",", $post['keywords']);
        $post['keywords'] = array_map("trim", $post['keywords']);
        $post['keywords'] = array_unique($post['keywords']);
        $post['keywords'] = implode(",", $post['keywords']);
    }
    if (empty($post['keywords'])) $post['keywords'] = nv_get_keywords((!empty($post['bodytext']) ? $post['bodytext'] : $post['introtext']));

    $_groups_post = $nv_Request->get_array('groups_view', 'post', []);
    $post['groups_view'] = !empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';

    $_groups_download = $nv_Request->get_array('groups_download', 'post', []);
    $post['groups_download'] = !empty($_groups_download) ? implode(',', nv_groups_post(array_intersect($_groups_download, array_keys($groups_list)))) : '';

    $post['files'] = [];
    $fileupload = $nv_Request->get_array('files', 'post');
    if (!empty($fileupload)) {
        $fileupload = array_map("trim", $fileupload);
        $fileupload = array_unique($fileupload);
        foreach ($fileupload as $_file) {
            if (preg_match("/^" . str_replace("/", "\/", NV_BASE_SITEURL . NV_UPLOADS_DIR) . "\//", $_file)) {
                $_file = substr($_file, strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));

                if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $_file)) {
                    $post['files'][] = $_file;
                }
            } elseif (preg_match("/^http*/", $_file)) {
                $post['files'][] = $_file;
            }
        }
    }
    $post['files'] = !empty($post['files']) ? implode(",", $post['files']) : "";

    $post['publtime'] = $nv_Request->get_title('publtime', 'post', '');
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $post['publtime'], $m)) {
        $post['publtime'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $post['publtime'] = 0;
    }
    if (empty($post['publtime']) && !defined('ACTIVE_COMMENTS')) {
        $error[] = $nv_Lang->getModule('erroNotSelectPubtime');
    }

    $post['exptime'] = $nv_Request->get_title('exptime', 'post', '');
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $post['exptime'], $m)) {
        $post['exptime'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $post['exptime'] = 0;
    }

    //Nếu là module lấy ý kiến thì lấy thời gian bắt đầu-kết thúc lấy ý kiến, trang thái thông qua của văn bản
    $post['start_comm_time'] = $nv_Request->get_title('start_comm_time', 'post', '');
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $post['start_comm_time'], $m)) {
        $post['start_comm_time'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $post['start_comm_time'] = 0;
    }

    $post['end_comm_time'] = $nv_Request->get_title('end_comm_time', 'post', '');
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $post['end_comm_time'], $m)) {
        $post['end_comm_time'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $post['end_comm_time'] = 0;
    }
    $post['approval'] = (int) $nv_Request->get_bool('approval', 'post', false);

    $post['startvalid'] = $nv_Request->get_title('startvalid', 'post', '');
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $post['startvalid'], $m)) {
        $post['startvalid'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $post['startvalid'] = 0;
    }

    // Nếu là module văn bản bình thường(k cho góp ý) thì bắt lỗi ngày ban hành <= Ngày có hiệu lực <=ngày hết hiệu lực
    if (!defined('ACTIVE_COMMENTS')) {
        if ($post['startvalid'] > 0) {
            if ($post['startvalid'] < $post['publtime']) {
                $error[] = $nv_Lang->getModule('erroStartvalid');
            } elseif ($post['exptime'] > 0 && ($post['exptime'] <= $post['publtime'] || $post['exptime'] <= $post['startvalid'])) {
                $error[] = $nv_Lang->getModule('erroExptime');
            }
        }
    }

    $post['sgid'] = $nv_Request->get_title('sgid', 'post', '');
    if (!is_numeric($post['sgid']) and !empty($post['sgid'])) {
        $result = $db->query("SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer WHERE title=" . $db->quote($post['title']) . " AND offices='' AND positions=''");
        if ($result->rowCount() == 0) {
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_signer (title, offices, positions, addtime) VALUES (" . $db->quote($post['sgid']) . ", '', '', " . NV_CURRENTTIME . ")";
            $post['sgid'] = $db->insert_id($sql);
        } else {
            $post['sgid'] = $result->fetchColumn();
        }
    } else {
        $post['sgid'] = intval($post['sgid']);
    }

    if (empty($error)) {
        if (!empty($post['id'])) {
            $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_row SET
                replacement=" . $db->quote($post['replacement']) . ",
                relatement=" . $db->quote($post['relatement']) . ",
                title=" . $db->quote($post['title']) . ",
                alias=" . $db->quote($alias . "-" . $post['id']) . ",
                code=" . $db->quote($post['code']) . ",
                area_ids=" . $db->quote(implode(',', $post['area_id'])) . ",
                cid=" . $post['cid'] . ",
                sid=" . $post['sid'] . ",
                eid=" . $post['eid'] . ",
                sgid=" . $post['sgid'] . ",
                approval=" . $post['approval'] . ",
                note=" . $db->quote($post['note']) . ",
                introtext=" . $db->quote($post['introtext']) . ",
                bodytext=" . $db->quote($post['bodytext']) . ",
                keywords=" . $db->quote($post['keywords']) . ",
                groups_view=" . $db->quote($post['groups_view']) . ",
                groups_download=" . $db->quote($post['groups_download']) . ",
                files=" . $db->quote($post['files']) . ",
                edittime=" . NV_CURRENTTIME . ",
                publtime=" . $post['publtime'] . ",
                exptime=" . $post['exptime'] . ",
                start_comm_time=" . $post['start_comm_time'] . ",
                end_comm_time=" . $post['end_comm_time'] . ",
                startvalid=" . $post['startvalid'] . ",
                admin_edit=" . $admin_info['userid'] . "
            WHERE id=" . $post['id'];
            $db->query($query);

            $_id = $post['id'];

            $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_set_replace WHERE nid=" . $post['id'];
            $db->query($sql);

            $replacement = explode(",", $post['replacement']);
            $replacement = array_filter($replacement);

            foreach ($replacement as $rep) {
                $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_set_replace VALUES( NULL, " . $post['id'] . ", " . $rep . " )");
            }

            // Cap nhat lai so luong van ban o chu de
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET numcount=(SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $post['sid'] . ' AND status=1) WHERE id=' . $post['sid']);

            nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('editRow'), "Id: " . $post['id'], $admin_info['userid']);
        } else {
            $query = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_row (
                replacement, relatement, title, alias, code, area_ids, cid, sid, eid, sgid,
                note, introtext, bodytext, keywords, groups_view, groups_download, files,
                status, approval, addtime, edittime, publtime, start_comm_time, end_comm_time,
                startvalid, exptime, view_hits, download_hits, admin_add, admin_edit
            ) VALUES (
                " . $db->quote($post['replacement']) . ",
                " . $db->quote($post['relatement']) . ",
                " . $db->quote($post['title']) . ",
                '',
                " . $db->quote($post['code']) . ",
                " . $db->quote(implode(',', $post['area_id'])) . ",
                " . $post['cid'] . ",
                " . $post['sid'] . ",
                " . $post['eid'] . ",
                " . $post['sgid'] . ",
                " . $db->quote($post['note']) . ",
                " . $db->quote($post['introtext']) . ",
                " . $db->quote($post['bodytext']) . ",
                " . $db->quote($post['keywords']) . ",
                " . $db->quote($post['groups_view']) . ",
                " . $db->quote($post['groups_download']) . ",
                " . $db->quote($post['files']) . ",
                1,  " . $post['approval'] . ",
                " . NV_CURRENTTIME . ", 0,
                " . $post['publtime'] . ",
                " . $post['start_comm_time'] . ",
                " . $post['end_comm_time'] . ",
                " . $post['startvalid'] . ",
                " . $post['exptime'] . ",
                0, 0, " . $admin_info['userid'] . ", 0
            );";
            $_id = $db->insert_id($query);

            if (empty($_id)) {
                $error[] = 'Error insert DB';
            } else {
                $alias .= "-" . $_id;
                $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_row SET alias=" . $db->quote($alias) . " WHERE id=" . $_id;
                $db->query($query);

                $replacement = explode(",", $post['replacement']);
                $replacement = array_filter($replacement);

                foreach ($replacement as $rep) {
                    $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_set_replace VALUES( NULL, " . $_id . ", " . $rep . " )");
                }

                // Cap nhat lai so luong van ban o chu de
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET numcount=(
                    SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $post['sid'] . ' AND status=1
                ) WHERE id=' . $post['sid']);

                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('addRow'), "Id: " . $_id, $admin_info['userid']);
            }
        }

        if (empty($error)) {
            $diff_add = array_diff($post['area_id'], $post['area_id_old']);
            $diff_delete = array_diff($post['area_id_old'], $post['area_id']);
            if (!empty($diff_add)) {
                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_row_area (row_id, area_id) VALUES(:row_id, :area_id)');
                foreach ($diff_add as $area_id) {
                    $sth->bindParam(':row_id', $_id, PDO::PARAM_INT);
                    $sth->bindParam(':area_id', $area_id, PDO::PARAM_INT);
                    $sth->execute();
                }
            }
            if (!empty($diff_delete)) {
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row_area
                WHERE area_id IN(' . implode(',', $diff_delete) . ') AND row_id=' . $_id);
            }

            $nv_Cache->delMod($module_name);
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        }
    }
}

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_DATA', $module_data);
$xtpl->assign('MODULE_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE);
$xtpl->assign('OP', $op);
$xtpl->assign('UPLOADS_DIR_USER', NV_UPLOADS_DIR . '/' . $module_upload);

// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

if (defined('NV_EDITOR')) {
    require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php');
}

if (!empty($post['introtext'])) $post['introtext'] = nv_htmlspecialchars(nv_br2nl($post['introtext']));
if (!empty($post['note'])) $post['note'] = nv_htmlspecialchars(nv_br2nl($post['note']));
if (!empty($post['bodytext'])) $post['bodytext'] = nv_htmlspecialchars(nv_editor_br2nl($post['bodytext']));

$post['select0'] = ($post['exptime'] == 0 or $post['exptime'] > NV_CURRENTTIME) ? " selected=\"selected\"" : "";
$post['select1'] = ($post['exptime'] != 0 and $post['exptime'] <= NV_CURRENTTIME) ? " selected=\"selected\"" : "";
$post['display'] = ($post['exptime'] == 0 or $post['exptime'] > NV_CURRENTTIME) ? ' hidden' : '';
$post['e0'] = ($post['approval'] == 0) ? " selected=\"selected\"" : "";
$post['e1'] = ($post['approval'] == 1) ? " selected=\"selected\"" : "";

$post['publtime'] = !empty($post['publtime']) ? date("d.m.Y", $post['publtime']) : "";
$post['exptime'] = !empty($post['exptime']) ? date("d.m.Y", $post['exptime']) : "";

$post['start_comm_time'] = !empty($post['start_comm_time']) ? date("d.m.Y", $post['start_comm_time']) : "";
$post['end_comm_time'] = !empty($post['end_comm_time']) ? date("d.m.Y", $post['end_comm_time']) : "";
$post['startvalid'] = !empty($post['startvalid']) ? date("d.m.Y", $post['startvalid']) : "";

$post['groups_view'] = array_filter(explode(',', $post['groups_view']));
$post['groups_download'] = array_filter(explode(',', $post['groups_download']));
$post['files'] = array_filter(explode(',', $post['files']));

$xtpl->assign('DATA', $post);

foreach ($catList as $_cat) {
    $_cat['selected'] = $_cat['id'] == $post['cid'] ? " selected=\"selected\"" : "";
    $xtpl->assign('CATOPT', $_cat);
    $xtpl->parse('main.catopt');
}

// Xử lý và xuất ra lĩnh vực
$area_ids = empty($post['id']) ? $allowed_area_add : $allowed_area_edit;
// Lấy cả các lĩnh vực cha để hiển thị cây thư mục
$area_ids_show = [];
foreach ($area_ids as $area_id) {
    $area_ids_show = array_merge($area_ids_show, nv_GetParentCatidInChild($area_id, $aList));
}
$area_ids_show = array_unique($area_ids_show);

foreach ($aList as $_a) {
    if (in_array($_a['id'], $area_ids_show)) {
        $_a['checked'] = in_array($_a['id'], $post['area_id']) ? " checked=\"checked\"" : "";
        $xtitle_i = '';
        if ($_a['lev'] > 0) {
            $xtitle_i .= '&nbsp;&nbsp;&nbsp;|';
            for ($i = 1; $i <= $_a['lev']; ++$i) {
                $xtitle_i .= '---';
            }
            $xtitle_i .= '>&nbsp;';
        }
        $xtitle_i .= $_a['title'];
        $_a['name'] = $xtitle_i;
        $_a['disabled'] = in_array($_a['id'], $area_ids) ? '' : ' disabled="disabled"';

        $xtpl->assign('AREAOPT', $_a);
        $xtpl->parse('main.areaopt');
    }
}

foreach ($sList as $_s) {
    if ($_s['add'] != 1 and $nv_Request->isset_request('add', 'get')) continue;
    $_s['selected'] = $_s['id'] == $post['sid'] ? " selected=\"selected\"" : "";
    $xtpl->assign('SUBOPT', $_s);
    $xtpl->parse('main.subopt');
}

if (defined('ACTIVE_COMMENTS')) {
    foreach ($eList as $_s) {
        $_s['selected'] = $_s['id'] == $post['eid'] ? " selected=\"selected\"" : "";
        $xtpl->assign('EXBOPT', $_s);
        $xtpl->parse('main.loop.exbopt');
    }
    $xtpl->parse('main.loop');
}

foreach ($sgList as $_sg) {
    $_sg['selected'] = $_sg['id'] == $post['sgid'] ? " selected=\"selected\"" : "";
    $xtpl->assign('SINGER', $_sg);
    $xtpl->parse('main.singers');

}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $_cont = nv_aleditor('bodytext', '100%', '300px', $post['bodytext']);
} else {
    $_cont = "<textarea style=\"width:100%;height:300px\" name=\"bodytext\" id=\"bodytext\">" . $post['bodytext'] . "</textarea>";
}
$xtpl->assign('CONTENT', $_cont);

$groups_views = [];
foreach ($groups_list as $group_id => $grtl) {
    $groups_views[] = array(
        'id' => $group_id,
        'checked' => in_array($group_id, $post['groups_view']) ? ' checked="checked"' : '',
        'title' => $grtl
    );
    $groups_downloads[] = array(
        'id' => $group_id,
        'checked' => in_array($group_id, $post['groups_download']) ? ' checked="checked"' : '',
        'title' => $grtl
    );
}

foreach ($groups_views as $data) {
    $xtpl->assign('GROUPS_VIEWS', $data);
    $xtpl->parse('main.group_view');
}

foreach ($groups_downloads as $data) {
    $xtpl->assign('GROUPS_DOWNLOAD', $data);
    $xtpl->parse('main.groups_download');
}

if (!empty($post['files'])) {
    foreach ($post['files'] as $_id => $_file) {
        if (!empty($_file)) {
            $xtpl->assign('FILEUPL', array(
                'id' => $_id,
                'value' => (!preg_match("/^http*/", $_file)) ? NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $_file : $_file
            ));
            $xtpl->parse('main.files');
        }
    }
} else {
    $xtpl->assign('FILEUPL', array(
        'id' => 0,
        'value' => ''
    ));
    $xtpl->parse('main.files');
}

// Kiểm tra nếu là module cho phép góp ý thì hiển thị trường thời gian góp ý
if (defined('ACTIVE_COMMENTS')) {
    $xtpl->parse('main.comment');
} else {
    $xtpl->parse('main.normal_laws');
}

$xtpl->assign('NUMFILE', sizeof($post['files']));

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
