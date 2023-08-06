<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

use NukeViet\Module\laws\Shared\Admins;

// Xác định và dừng trang nếu quản lý module bị phân quyền rỗng
$catList = nv_catList();
list($sList, $sListAdd) = nv_sList();
$eList = nv_eList();
$sgList = nv_sgList();

if (!defined('NV_IS_ADMIN_MODULE') and (empty($sList) or empty($allowed_area_view))) {
    $contents = nv_theme_alert($nv_Lang->getModule('info'), $nv_Lang->getModule('info_no_permission'));
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

// Cập nhật trạng thái văn bản
if ($nv_Request->isset_request('changestatus', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);

    $sql = "SELECT status, sid FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id=" . $id;
    $result = $db->query($sql);
    $row = $result->fetch();
    if (empty($row)) {
        nv_htmlOutput('ERROR');
    }
    $row['area_ids'] = empty($row['area_ids']) ? [] : explode(',', $row['area_ids']);

    // Kiểm tra quyền sửa
    $edit = false;
    if (ADMIN_TYPE == Admins::TYPE_ADMIN) {
        $edit = true;
    } elseif (ADMIN_TYPE == Admins::TYPE_AREA) {
        $edit = !empty(array_intersect($row['area_ids'], $allowed_area_edit));
    } elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
        $edit = (!empty($array_subject_admin[$admin_id][$row['sid']]['admin']) or !empty($array_subject_admin[$admin_id][$row['sid']]['edit_content']));
    }
    if (!$edit) {
        nv_htmlOutput('ERROR');
    }

    $status = $row['status'];
    if ($status != 1) {
        $status = 1;
    } else {
        $status = 0;
    }

    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_row SET status=" . $status . " WHERE id=" . $id;
    if ($db->query($sql) === false) {
        nv_htmlOutput("ERROR");
    }

    // Cập nhật lại thống kê số văn bản của cơ quan ban hành
    if (!empty($row['sid'])) {
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET numcount=IFNULL((
            SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $row['sid'] . ' AND status=1
        ), 0) WHERE id=' . $row['sid']);
    }

    // Ghi log
    nv_insert_logs(NV_LANG_DATA, $module_name, 'Log change Status', "Id: " . $id, $admin_info['userid']);
    $nv_Cache->delMod($module_name);
    nv_htmlOutput('OK');
}

// Xóa văn bản
if ($nv_Request->isset_request('del', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $listid = $nv_Request->get_title('listid', 'post', '');
    $listid = $listid . ',' . $id;
    $listid = array_filter(array_unique(array_map('intval', explode(',', $listid))));

    foreach ($listid as $id) {
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id=" . $id;
        $result = $db->query($sql);
        $row = $result->fetch();
        if (empty($row)) {
            continue;
        }
        $row['area_ids'] = empty($row['area_ids']) ? [] : explode(',', $row['area_ids']);

        // Kiểm tra quyền xóa
        $del = false;
        if (ADMIN_TYPE == Admins::TYPE_ADMIN) {
            $del = true;
        } elseif (ADMIN_TYPE == Admins::TYPE_AREA) {
            $del = !empty(array_intersect($row['area_ids'], $allowed_area_del));
        } elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
            $del = (!empty($array_subject_admin[$admin_id][$row['sid']]['admin']) or !empty($array_subject_admin[$admin_id][$row['sid']]['del_content']));
        }
        if (!$del) {
            continue;
        }

        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE id = " . $id;
        $db->query($sql);

        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_set_replace WHERE oid = " . $id;
        $db->query($sql);

        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_row_area WHERE row_id=" . $id;
        $db->query($sql);

        // Cap nhat lai so luong van ban o chu de
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET numcount=IFNULL((
            SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $row['sid'] . ' AND status=1
        ), 0) WHERE id=' . $row['sid']);

        nv_insert_logs(NV_LANG_DATA, $module_name, 'Del law', "Id: " . $id, $admin_info['userid']);
    }

    $nv_Cache->delMod($module_name);
    nv_htmlOutput('OK');
}

$page_title = $nv_Lang->getModule('main_title');

$per_page = 20;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

// Phần tìm kiếm
$array_search = [];
$array_search['q'] = $nv_Request->get_title('q', 'get', '');
$array_search['cat_id'] = $nv_Request->get_absint('cid', 'get', 0);
$array_search['area_id'] = $nv_Request->get_absint('aid', 'get', 0);
$array_search['subject_id'] = $nv_Request->get_absint('sid', 'get', 0);
$array_search['examine_id'] = $nv_Request->get_absint('eid', 'get', 0);
$array_search['signer_id'] = $nv_Request->get_absint('sgid', 'get', 0);

$db->sqlreset()->select('COUNT(*)')->from(NV_PREFIXLANG . '_' . $module_data . '_row');

$where = [];
$is_search = false;
if (ADMIN_TYPE == Admins::TYPE_AREA) {
    $where_or = [];
    foreach ($allowed_area_view as $area_id) {
        $where_or[] = 'FIND_IN_SET(' . $area_id . ', area_ids)';
    }
    $where[] = '(' . implode(' OR ', $where_or) . ')';
} elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
    $where[] = 'sid IN(' . implode(',', array_keys($sList)) . ')';
}
// Tìm từ khóa
if (!empty($array_search['q'])) {
    $base_url .= '&amp;q=' . urlencode($array_search['q']);
    $dblikekey = $db->dblikeescape($array_search['q']);
    $where[] = "(
        title LIKE '%" . $dblikekey . "%' OR
        code LIKE '%" . $dblikekey . "%' OR
        note LIKE '%" . $dblikekey . "%' OR
        introtext LIKE '%" . $dblikekey . "%' OR
        bodytext LIKE '%" . $dblikekey . "%'
    )";
}

// Tìm thể loại
if ($array_search['cat_id'] and isset($catList[$array_search['cat_id']])) {
    $base_url .= '&amp;cid=' . $array_search['cat_id'];
    $where[] = "cid IN (" . implode(',', nv_GetCatidInParent($array_search['cat_id'], $catList)) . ")";
    $is_search = true;
}

// Tìm lĩnh vực
if ($array_search['area_id'] and in_array($array_search['area_id'], $allowed_area_view)) {
    $base_url .= '&amp;aid=' . $array_search['area_id'];
    $where_or = [];
    $area_ids = nv_GetCatidInParent($array_search['area_id'], $aList);
    foreach ($area_ids as $area_id) {
        $where_or[] = 'FIND_IN_SET(' . $area_id . ', area_ids)';
    }
    $where[] = '(' . implode(' OR ', $where_or) . ')';
    $is_search = true;
}

// Tìm cơ quan ban hành
if ($array_search['subject_id'] and isset($sList[$array_search['subject_id']])) {
    $base_url .= '&amp;sid=' . $array_search['subject_id'];
    $where[] = 'sid=' . $array_search['subject_id'];
    $is_search = true;
}

// Tìm cơ quan thẩm tra
if (defined('ACTIVE_COMMENTS') and $array_search['examine_id'] and isset($eList[$array_search['examine_id']])) {
    $base_url .= '&amp;eid=' . $array_search['examine_id'];
    $where[] = 'eid=' . $array_search['examine_id'];
    $is_search = true;
}

// Tìm người ký
if ($array_search['signer_id'] and isset($sgList[$array_search['signer_id']])) {
    $base_url .= '&amp;sgid=' . $array_search['signer_id'];
    $where[] = 'sgid=' . $array_search['signer_id'];
    $is_search = true;
}

// Phần sắp xếp
$array_order = [];
$array_order['field'] = $nv_Request->get_title('of', 'get', '');
$array_order['value'] = $nv_Request->get_title('ov', 'get', '');
$base_url_order = $base_url;
if ($page > 1) {
    $base_url_order .= '&amp;page=' . $page;
}

// Định nghĩa các field và các value được phép sắp xếp
if (defined('ACTIVE_COMMENTS')) {
    $order_fields = ['title', 'start_comm_time', 'end_comm_time'];
} else {
    $order_fields = ['title', 'publtime', 'exptime'];
}
$order_values = ['asc', 'desc'];

if (!in_array($array_order['field'], $order_fields)) {
    $array_order['field'] = '';
}
if (!in_array($array_order['value'], $order_values)) {
    $array_order['value'] = '';
}

if (!empty($where)) {
    $db->where(implode(' AND ', $where));
}

$num_items = $db->query($db->sql())->fetchColumn();
if (empty($num_items) and !$is_search and $page = 1) {
    if (empty($catList)) {
        $type = $nv_Lang->getModule('cat_manager');
        $href = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat&add';
    } elseif (empty($aList)) {
        $type = $nv_Lang->getModule('area_manager');
        $href = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=area&add';
    } elseif (empty($sList)) {
        $type = $nv_Lang->getModule('subject');
        $href = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=subject&add';
    } elseif (empty($eList) and defined('ACTIVE_COMMENTS')) {
        $type = $nv_Lang->getModule('examine');
        $href = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=examine&add';
    } elseif (empty($sgList)) {
        $type = $nv_Lang->getModule('signer');
        $href = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=signer&add';
    } else {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content');
    }

    $message_content = $nv_Lang->getModule('msg1') . ' ' . $type . ' ' . $nv_Lang->getModule('msg2') . '. ' . $nv_Lang->getModule('msg5');
    $contents = nv_theme_alert($nv_Lang->getModule('info'), $message_content, 'info', $href, $nv_Lang->getModule('msg3') . ' ' . $nv_Lang->getModule('msg4'));
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

if (!empty($array_order['field']) and !empty($array_order['value'])) {
    $order = $array_order['field'] . ' ' . $array_order['value'];
} else {
    $order = 'id DESC';
}
$db->select('*')->order($order)->limit($per_page)->offset(($page - 1) * $per_page);
$result = $db->query($db->sql());

$array = $array_userids = [];
while ($row = $result->fetch()) {
    $array[$row['id']] = $row;
    if (!empty($row['admin_add'])) {
        $array_userids[$row['admin_add']] = $row['admin_add'];
    }
}

// Lấy thành viên
$array_users = [];
if (!empty($array_userids)) {
    $sql = "SELECT userid, username, first_name, last_name, email
    FROM " . NV_USERS_GLOBALTABLE . " WHERE userid IN(" . implode(',', $array_userids) . ")";
    $result = $db->query($sql);

    while ($row = $result->fetch()) {
        $row['full_name'] = nv_show_name_user($row['first_name'], $row['last_name']);
        $row['show_name'] = $row['username'];
        if (!empty($row['full_name'])) {
            $row['show_name'] .= ' (' . $row['full_name'] . ')';
        }
        $array_users[$row['userid']] = $row;
    }
}

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('OP', $op);

$xtpl->assign('LINK_ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content');

$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('NUM_ITEMS', number_format($num_items, 0, ',', '.'));

$have_functions = false;
$have_delete = false;
foreach ($array as $row) {
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['detail'] . '/' . $row['alias'];
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $row['id'];
    $row['status_render'] = $row['status'] ? ' checked="checked"' : '';
    $row['status_text'] = $row['status'] ? $nv_Lang->getModule('status1') : $nv_Lang->getModule('status0');
    $row['admin_add'] = isset($array_users[$row['admin_add']]) ? $array_users[$row['admin_add']]['show_name'] : ('#' . $row['admin_add']);
    $row['area_ids'] = empty($row['area_ids']) ? [] : explode(',', $row['area_ids']);

    $row['publtime'] = $row['publtime'] ? nv_date('d/m/Y', $row['publtime']) : '';
    $row['exptime'] = $row['exptime'] ? nv_date('d/m/Y', $row['exptime']) : '';
    $row['start_comm_time'] = $row['start_comm_time'] ? nv_date('d/m/Y', $row['start_comm_time']) : '';
    $row['end_comm_time'] = $row['end_comm_time'] ? nv_date('d/m/Y', $row['end_comm_time']) : '';
    $row['url_view_comm'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=comment&amp;" . NV_OP_VARIABLE . "=main&amp;module=" . $module_name . "&amp;q=" . $row['id'] . "&amp;stype=content_id&amp;sstatus=2&amp;per_page=20";
    if ($row['start_comm_time'] != '') {
        $row['url_view_comm'] .= "&amp;from_date=" . $row['start_comm_time'];
    }
    if ($row['end_comm_time'] != '') {
        $row['url_view_comm'] .= "&amp;to_date=" . $row['end_comm_time'];
    }

    $xtpl->assign('ROW', $row);

    $tools = 0;
    if (defined('ACTIVE_COMMENTS')) {
        $xtpl->parse('main.loop.col_comment');

        if (isset($site_mods['comment'])) {
            $xtpl->parse('main.loop.tools.view_comment');
            $tools++;
        }
    } else {
        $xtpl->parse('main.loop.col_nocomment');
    }

    // Kiểm tra quyền sửa
    $edit = false;
    if (ADMIN_TYPE == Admins::TYPE_ADMIN) {
        $edit = true;
    } elseif (ADMIN_TYPE == Admins::TYPE_AREA) {
        $edit = !empty(array_intersect($row['area_ids'], $allowed_area_edit));
    } elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
        $edit = (!empty($array_subject_admin[$admin_id][$row['sid']]['admin']) or !empty($array_subject_admin[$admin_id][$row['sid']]['edit_content']));
    }
    if ($edit) {
        $xtpl->parse('main.loop.tools.edit');
        $tools++;

        $xtpl->parse('main.loop.status_action');
    } else {
        $xtpl->parse('main.loop.status_text');
    }

    // Kiểm tra quyền xóa
    $del = false;
    if (ADMIN_TYPE == Admins::TYPE_ADMIN) {
        $del = true;
    } elseif (ADMIN_TYPE == Admins::TYPE_AREA) {
        $del = !empty(array_intersect($row['area_ids'], $allowed_area_del));
    } elseif (ADMIN_TYPE == Admins::TYPE_SUBJECT) {
        $del = (!empty($array_subject_admin[$admin_id][$row['sid']]['admin']) or !empty($array_subject_admin[$admin_id][$row['sid']]['del_content']));
    }
    if ($del) {
        $xtpl->parse('main.loop.tools.delete');
        $xtpl->parse('main.loop.sel');
        $tools++;
        $have_delete = true;
    }

    if ($tools > 0) {
        $xtpl->parse('main.loop.tools');
        $have_functions = true;
    }

    $xtpl->parse('main.loop');
}

// Xuất các phần sắp xếp
foreach ($order_fields as $field) {
    $url = $base_url_order;
    if ($array_order['field'] == $field) {
        if (empty($array_order['value'])) {
            $url .= '&amp;of=' . $field . '&amp;ov=asc';
            $icon = '<i class="fa fa-sort" aria-hidden="true"></i>';
        } elseif ($array_order['value'] == 'asc') {
            $url .= '&amp;of=' . $field . '&amp;ov=desc';
            $icon = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
        } else {
            $icon = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
        }
    } else {
        $url .= '&amp;of=' . $field . '&amp;ov=asc';
        $icon = '<i class="fa fa-sort" aria-hidden="true"></i>';
    }

    $xtpl->assign(strtoupper('URL_ORDER_' . $field), $url);
    $xtpl->assign(strtoupper('ICON_ORDER_' . $field), $icon);
}

if (defined('ACTIVE_COMMENTS')) {
    $xtpl->parse('main.col_comment');
} else {
    $xtpl->parse('main.col_nocomment');
}
if ($have_delete) {
    $xtpl->parse('main.action_checlall');
    $xtpl->parse('main.action_btns');
}

if (ADMIN_TYPE == Admins::TYPE_ADMIN or $have_functions) {
    $xtpl->parse('main.col_tools');
    $xtpl->assign('NUM_COLS', 7);
} else {
    $xtpl->assign('NUM_COLS', 6);
}

// Xuất phân trang
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

if (ADMIN_TYPE == Admins::TYPE_ADMIN or (!empty($sListAdd) and !empty($allowed_area_add))) {
    $xtpl->parse('main.add');
}

// Xuất thể loại
foreach ($catList as $_cat) {
    $_cat['selected'] = $_cat['id'] == $array_search['cat_id'] ? ' selected="selected"' : '';
    $xtpl->assign('CATOPT', $_cat);
    $xtpl->parse('main.catParent');
}

// Xác định các lĩnh vực hiển thị (bao gồm cả lĩnh vực cha nếu không có quyền quản lý)
if (ADMIN_TYPE == Admins::TYPE_AREA) {
    $area_ids_show = [];
    foreach ($allowed_area_view as $area_id) {
        $area_ids_show = array_merge($area_ids_show, nv_GetParentCatidInChild($area_id, $aList));
    }
    $area_ids_show = array_unique($area_ids_show);
} else {
    $area_ids_show = $allowed_area_view;
}
// Xuất lĩnh vực
foreach ($aList as $_aList) {
    if (in_array($_aList['id'], $area_ids_show)) {
        $xtitle_i = '';
        if ($_aList['lev'] > 0) {
            $xtitle_i .= '&nbsp;&nbsp;&nbsp;|';
            for ($i = 1; $i <= $_aList['lev']; ++$i) {
                $xtitle_i .= '---';
            }
            $xtitle_i .= '>&nbsp;';
        }
        $xtitle_i .= $_aList['title'];
        $_aList['name'] = $xtitle_i;
        $_aList['selected'] = $_aList['id'] == $array_search['area_id'] ? ' selected="selected"' : '';
        $_aList['disabled'] = in_array($_aList['id'], $allowed_area_view) ? '' : ' disabled="disabled"';

        $xtpl->assign('ALIST', $_aList);
        $xtpl->parse('main.alist');
    }
}

// Xuất cơ quan ban hành
foreach ($sList as $_sList) {
    $_sList['selected'] = $_sList['id'] == $array_search['subject_id'] ? ' selected="selected"' : '';
    $xtpl->assign('SLIST', $_sList);
    $xtpl->parse('main.slist');
}

// Xuất người ký
foreach ($sgList as $_sgList) {
    $_sgList['selected'] = $_sgList['id'] == $array_search['signer_id'] ? ' selected="selected"' : '';
    $xtpl->assign('SGLIST', $_sgList);
    $xtpl->parse('main.sglist');
}

// Xuất cơ quan thẩm tra
if (defined('ACTIVE_COMMENTS')) {
    foreach ($eList as $_eList) {
        $_eList['selected'] = $_eList['id'] == $array_search['examine_id'] ? ' selected="selected"' : '';
        $xtpl->assign('ELIST', $_eList);
        $xtpl->parse('main.elist_loop.elist');
    }
    $xtpl->parse('main.elist_loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
