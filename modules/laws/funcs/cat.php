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

$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;

if (empty($catid)) {
    nv_redirect_location($base_url, true);
}
if (isset($array_op[1])) {
    nv_redirect_location($base_url);
}

// Set page title, keywords, description
$page_title = $mod_title = $nv_laws_listcat[$catid]['title'];
$key_words = empty($nv_laws_listcat[$catid]['keywords']) ? $module_info['keywords'] : $nv_laws_listcat[$catid]['keywords'];
$description = empty($nv_laws_listcat[$catid]['introduction']) ? $page_title : $nv_laws_listcat[$catid]['introduction'];

//
$page = $nv_Request->get_int('page', 'get', 1);
$per_page = $nv_laws_setting['numsub'];
$page_url = $base_url .=  "&amp;" . NV_OP_VARIABLE . "=" . $nv_laws_listcat[$catid]['alias'];

if ($page > 1) {
    $page_url .= '&amp;page=' . $page;
}

$canonicalUrl = getCanonicalUrl($page_url);

if (!defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $cat = $nv_laws_listcat[$catid];
    $in = '';
    if (empty($cat['subcats'])) {
        $in = " cid=" . $catid;
    } else {
        $in = $cat['subcats'];
        $in[] = $catid;
        $in = " cid IN(" . implode(",", $in) . ")";
    }

    $order = ($nv_laws_setting['typeview'] == 1 or $nv_laws_setting['typeview'] == 4) ? "ASC" : "DESC";
    $order_param = ($nv_laws_setting['typeview'] == 0 or $nv_laws_setting['typeview'] == 1) ? "publtime" : "addtime";

    $db->sqlreset()->select('COUNT(id)')->from(NV_PREFIXLANG . "_" . $module_data . "_row");
    $db->where("status=1 AND" . $in);

    $all_page = $db->query($db->sql())->fetchColumn();
    betweenURLs($page, ceil($all_page / $per_page), $base_url, '&amp;page=', $prevPage, $nextPage);

    $db->select('*')->order($order_param . ' ' . $order)->limit($per_page)->offset(($page - 1) * $per_page);
    $result = $db->query($db->sql());

    $generate_page = nv_generate_page($base_url, $all_page, $per_page, $page);
    $array_data = raw_law_list_by_result($result, $page, $per_page);
    $contents = nv_theme_laws_cat($array_data, $generate_page, $cat);

    if (!defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
