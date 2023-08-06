<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

use NukeViet\Module\laws\Shared\Admins;

$allow_func = [
    'main',
    'content',
    'area',
    'subject',
    'examine',
    'getlid',
    'scontent',
    'change_cat',
    'view'
];
if ($NV_IS_ADMIN_MODULE) {
    $allow_func[] = 'signer';
    $allow_func[] = 'scontent';
    $allow_func[] = 'area';
    $allow_func[] = 'cat';
    $allow_func[] = 'subject';
    define('NV_IS_ADMIN_MODULE', true);
    define('ADMIN_TYPE', Admins::TYPE_ADMIN);
} elseif (!empty($array_area_admin)) {
    define('ADMIN_TYPE', Admins::TYPE_AREA);
} else {
    define('ADMIN_TYPE', Admins::TYPE_SUBJECT);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    $allow_func[] = 'admins';
    $allow_func[] = 'config';

    define('NV_IS_ADMIN_FULL_MODULE', true);
}
// Admin module hoặc phân quyền theo lĩnh vực thì đủ quyền với cơ quan ban hành
if ($NV_IS_ADMIN_MODULE or !empty($array_area_admin)) {
    define('FULL_ACCESS_SUBJECT', true);
}
if (!empty($module_config[$module_name]['activecomm'])) {
    define('ACTIVE_COMMENTS', true);
}
define('NV_IS_FILE_ADMIN', true);

// Lĩnh vực
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_area ORDER BY sort ASC";
$aList = $nv_Cache->db($sql, 'id', $module_name);

/*
 * Xác định quyền xem, thêm, sửa, xóa văn bản theo lĩnh vực
 * empty($array_area_admin) tức là phân quyền theo cơ quan hoặc không có lĩnh vực
 */
$allowed_area_edit = $allowed_area_add = $allowed_area_del = $allowed_area_view = [];
foreach ($aList as $area) {
    if ($NV_IS_ADMIN_MODULE or empty($array_area_admin)) {
        // Full quyền các lĩnh vực
        $allowed_area_edit[] = $area['id'];
        $allowed_area_add[] = $area['id'];
        $allowed_area_del[] = $area['id'];
        $allowed_area_view[] = $area['id'];
    } else {
        $view = 0;
        if (!empty($array_area_admin[$admin_id][$area['id']]['add_content']) or !empty($array_area_admin[$admin_id][$area['id']]['admin'])) {
            $view = 1;
            $allowed_area_add = array_merge($allowed_area_add, nv_GetCatidInParent($area['id'], $aList));
        }
        if (!empty($array_area_admin[$admin_id][$area['id']]['edit_content']) or !empty($array_area_admin[$admin_id][$area['id']]['admin'])) {
            $view = 1;
            $allowed_area_edit = array_merge($allowed_area_edit, nv_GetCatidInParent($area['id'], $aList));
        }
        if (!empty($array_area_admin[$admin_id][$area['id']]['del_content']) or !empty($array_area_admin[$admin_id][$area['id']]['admin'])) {
            $view = 1;
            $allowed_area_del = array_merge($allowed_area_del, nv_GetCatidInParent($area['id'], $aList));
        }
        if ($view) {
            $allowed_area_view = array_merge($allowed_area_view, nv_GetCatidInParent($area['id'], $aList));
        }
    }
}
$allowed_area_edit = array_unique($allowed_area_edit);
$allowed_area_add = array_unique($allowed_area_add);
$allowed_area_del = array_unique($allowed_area_del);
$allowed_area_view = array_unique($allowed_area_view);

function nv_setCats($list2, $id, $list, $num = 0)
{
    $num++;
    $defis = "";
    for ($i = 0; $i < $num; $i++) {
        $defis .= "---";
    }

    if (isset($list[$id])) {
        foreach ($list[$id] as $value) {
            $list2[$value['id']] = $value;
            $list2[$value['id']]['count'] = isset($list[$value['id']]) ? count($list[$value['id']]) : 0;
            $list2[$value['id']]['pcount'] = count($list[$list2[$value['id']]['parentid']]);
            $list2[$value['id']]['name'] = "&nbsp;|" . $defis . " " . $list2[$value['id']]['name'];
            if (isset($list[$value['id']])) {
                $list2 = nv_setCats($list2, $value['id'], $list, $num);
            }
        }
    }
    return $list2;
}

function nv_catList()
{
    global $db, $module_data;

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat ORDER BY parentid,weight ASC";
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['parentid']][] = array( //
            'id' => (int) $row['id'], //
            'parentid' => (int) $row['parentid'], //
            'title' => $row['title'], //
            'alias' => $row['alias'], //
            'weight' => (int) $row['weight'], //
            'name' => $row['title'], //
            'newday' => $row['newday'] //
        );
    }

    if (empty($list)) {
        return $list;
    }

    $list2 = array();
    foreach ($list[0] as $value) {
        $list2[$value['id']] = $value;
        $list2[$value['id']]['count'] = isset($list[$value['id']]) ? count($list[$value['id']]) : 0;
        $list2[$value['id']]['pcount'] = count($list[$list2[$value['id']]['parentid']]);
        if (isset($list[$value['id']])) {
            $list2 = nv_setCats($list2, $value['id'], $list);
        }
    }

    return $list2;
}

function fix_catWeight($parentid)
{
    global $db, $module_data;

    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . intval($parentid) . " ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($query);
    }
}

/**
 * @param number $parentid
 * @param number $order
 * @param number $lev
 * @return number
 */
function fix_aWeight($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;

    $sql = "SELECT id, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_area WHERE parentid=" . $parentid . " ORDER BY weight ASC";
    $result = $db->query($sql);
    $array_cat_order = [];
    while ($row = $result->fetch()) {
        $array_cat_order[] = $row['id'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_cat_order as $id_i) {
        ++$order;
        ++$weight;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_area SET weight=" . $weight . ", sort=" . $order . ", lev=" . $lev . " WHERE id=" . intval($id_i);
        $db->query($sql);
        $order = fix_aWeight($id_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_area SET numsubcat=" . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ", subcatid=''";
        } else {
            $sql .= ", subcatid='" . implode(',', $array_cat_order) . "'";
        }
        $sql .= " WHERE id=" . intval($parentid);
        $db->query($sql);
    }
    return $order;
}

/**
 * @return array
 */
function nv_sList()
{
    global $db, $module_data, $array_subject_admin, $admin_id;

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_subject ORDER BY weight ASC";
    $result = $db->query($sql);
    $list = [];
    $add = 0;
    $listAdd = [];
    while ($row = $result->fetch()) {
        if (defined('FULL_ACCESS_SUBJECT') or !empty($array_subject_admin[$admin_id][$row['id']]['admin']) or !empty($array_subject_admin[$admin_id][$row['id']]['add_content']) or !empty($array_subject_admin[$admin_id][$row['id']]['edit_content']) or !empty($array_subject_admin[$admin_id][$row['id']]['del_content'])) {
            $add = (defined('FULL_ACCESS_SUBJECT') or !empty($array_subject_admin[$admin_id][$row['id']]['add_content']) or !empty($array_subject_admin[$admin_id][$row['id']]['admin'])) ? 1 : 0;
            $list[$row['id']] = [
                'id' => (int) $row['id'],
                'title' => $row['title'],
                'alias' => $row['alias'],
                'numlink' => $row['numlink'],
                'add' => $add,
                'weight' => (int) $row['weight']
            ];
            if ($add) {
                $listAdd[] = $row['id'];
            }
        }
    }

    return [$list, $listAdd];
}

function nv_eList()
{
    global $db, $module_data;

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_examine ORDER BY weight ASC";
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['id']] = array( //
            'id' => (int) $row['id'], //
            'title' => $row['title'], //
            'weight' => (int) $row['weight'] //
        );
    }

    return $list;
}

function nv_sgList()
{
    global $db, $module_data;

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer ORDER BY id ASC";
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['id']] = array( //
            'id' => (int) $row['id'], //
            'title' => $row['title'] //
            //'alias' => $row['alias'], //
            //'weight' => ( int )$row['weight'] //
        );
    }

    return $list;
}

function fix_subjectWeight()
{
    global $db, $module_data;

    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_subject ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_subject SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($query);
    }
}

function fix_examineWeight()
{
    global $db, $module_data;

    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_examine ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_examine SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($query);
    }
}

/**
 * Lấy ID mục con bao gồm cả nó
 *
 * @param int $id
 * @param array $array_cat
 * @return int[]
 */
function nv_GetCatidInParent($id, $array_cat)
{
    if (!isset($array_cat[$id])) {
        return [$id];
    }
    if (isset($array_cat[$id]['subcatid'])) {
        return array_filter(array_unique(array_map('intval', explode(',', $id . ',' . $array_cat[$id]['subcatid']))));
    }
    $array_id = [];
    $array_id[] = $id;
    foreach ($array_cat as $cat) {
        if ($cat['parentid'] == $id) {
            $array_id[] = $cat['id'];
            $array_id_tmp = nv_GetCatidInParent($cat['id'], $array_cat);
            foreach ($array_id_tmp as $id_tmp) {
                $array_id[] = $id_tmp;
            }
        }
    }
    return array_unique($array_id);
}

/**
 * Lấy ID mục cha bao gồm cả nó
 *
 * @param int $id
 * @param array $array_cat
 * @return int[]
 */
function nv_GetParentCatidInChild($id, $array_cat)
{
    $return = [];
    $parentid = $id;
    while ($parentid > 0) {
        if (isset($array_cat[$parentid])) {
            $return[] = $parentid;
            $parentid = $array_cat[$parentid]['parentid'];
        } else {
            break;
        }
    }
    return $return;
}
