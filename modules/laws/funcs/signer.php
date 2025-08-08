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

$id = isset($array_op[1]) ? intval($array_op[1]) : 0;
$page_url = $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_signer WHERE id=' . $id;
$result = $db->query($sql);
$signer = $result->fetch();
if (empty($signer)) {
    nv_redirect_location($base_url, true);
}

$base_url .= '&amp;' . NV_OP_VARIABLE . '=signer/' . $signer['id'] . '/' . change_alias($signer['title']);
$page_url = $base_url;
$page = 1;
if (isset($array_op[3]) and substr($array_op[3], 0, 5) == 'page-') {
    $page = intval(substr($array_op[3], 5));
    $page_url .= '/page-' . $page;
}

$page_url = nv_url_rewrite($page_url, true);
$canonicalUrl = getCanonicalUrl($page_url);

$per_page = $nv_laws_setting['numsub'];

$page_title = $mod_title = $signer['title'];
$key_words = $module_info['keywords'];
$description = $signer['title'] . ' - ' . $signer['offices'] . ' - ' . $signer['positions'];

if (!defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_sig' . $id . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file, 3600)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $order = ($nv_laws_setting['typeview'] == 1) ? 'ASC' : 'DESC';

    $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE status=1 AND sgid=' . $signer['id'] . ' ORDER BY addtime ' . $order . ' LIMIT ' . $per_page . ' OFFSET ' . ($page - 1) * $per_page;
    $result = $db->query($sql);
    $query = $db->query('SELECT FOUND_ROWS()');
    $all_page = $query->fetchColumn();

    betweenURLs($page, ceil($all_page/$per_page), $base_url, '/page-', $prevPage, $nextPage);

    $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
    $array_data = raw_law_list_by_result($result, $page, $per_page);
    $contents = nv_theme_laws_signer($array_data, $generate_page, $signer);

    if (!defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents, 3600);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
