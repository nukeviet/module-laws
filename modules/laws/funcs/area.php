<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LAWS')) {
    die('Stop!!!');
}

$alias = isset($array_op[1]) ? $array_op[1] : "";
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;
if (!preg_match("/^([a-z0-9\-\_\.]+)$/i", $alias)) {
    nv_redirect_location($base_url, true);
}

$page = 1;
if (isset($array_op[2])) {
    if (preg_match('/^page\-([0-9]{1,10})$/', $array_op[2], $m)) {
        $page = intval($m[1]);
    } else {
        nv_redirect_location($base_url);
    }
}
if (isset($array_op[3])) {
    nv_redirect_location($base_url);
}

$catid = 0;
foreach ($nv_laws_listarea as $c) {
    if ($c['alias'] == $alias) {
        $catid = $c['id'];
        break;
    }
}

if (empty($catid)) {
    nv_redirect_location($base_url, true);
}

// Set page title, keywords, description
$page_title = $mod_title = $nv_laws_listarea[$catid]['title'];
$key_words = empty($nv_laws_listarea[$catid]['keywords']) ? $module_info['keywords'] : $nv_laws_listarea[$catid]['keywords'];
$description = empty($nv_laws_listarea[$catid]['introduction']) ? $page_title : $nv_laws_listarea[$catid]['introduction'];

//
$per_page = $nv_laws_setting['numsub'];
$page_url = $base_url .= "&amp;" . NV_OP_VARIABLE . "=area/" . $nv_laws_listarea[$catid]['alias'];

if ($page > 1) {
    $page_url .= '/page-' . $page;
}
$canonicalUrl = getCanonicalUrl($page_url);

if (!defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file, 3600)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $cat = $nv_laws_listarea[$catid];
    $in = "";
    if (empty($cat['subcats'])) {
        $in = " t2.area_id=" . $catid;
    } else {
        $in = $cat['subcats'];
        $in[] = $catid;
        $in = " t2.area_id IN(" . implode(",", $in) . ")";
    }

    $order = ($nv_laws_setting['typeview'] == 1 or $nv_laws_setting['typeview'] == 4) ? "ASC" : "DESC";
    $order_param = ($nv_laws_setting['typeview'] == 0 or $nv_laws_setting['typeview'] == 1) ? (defined('ACTIVE_COMMENTS') ? 'start_comm_time' : 'publtime') : "addtime";

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . NV_PREFIXLANG . "_" . $module_data . "_row t1
    INNER JOIN " . NV_PREFIXLANG . "_" . $module_data . "_row_area t2 ON t1.id=t2.row_id
    WHERE status=1 AND" . $in . " ORDER BY  " .  $order_param . " " . $order . " LIMIT " . $per_page . " OFFSET " . (($page - 1) * $per_page);
    $result = $db->query($sql);
    $query = $db->query("SELECT FOUND_ROWS()");
    $all_page = $query->fetchColumn();

    betweenURLs($page, ceil($all_page/$per_page), $base_url, '/page-', $prevPage, $nextPage);

    $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
    $array_data = $array_data = raw_law_list_by_result($result, $page, $per_page);
    $contents = nv_theme_laws_area($array_data, $generate_page, $cat);

    if (!defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents, 3600);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
