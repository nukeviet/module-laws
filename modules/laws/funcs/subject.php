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
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

if (!preg_match("/^([a-z0-9\-\_\.]+)$/i", $alias)) {
    nv_redirect_location($base_url, true);
}

$catid = 0;
foreach ($nv_laws_listsubject as $c) {
    if ($c['alias'] == $alias) {
        $catid = $c['id'];
        break;
    }
}

if (empty($catid)) {
    nv_redirect_location($base_url, true);
}

// Set page title, keywords, description
$page_title = $mod_title = $nv_laws_listsubject[$catid]['title'];
$key_words = empty($nv_laws_listsubject[$catid]['keywords']) ? $module_info['keywords'] : $nv_laws_listsubject[$catid]['keywords'];
$description = empty($nv_laws_listsubject[$catid]['introduction']) ? $page_title : $nv_laws_listsubject[$catid]['introduction'];

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

$per_page = $nv_laws_setting['numsub'];
$page_url = $base_url .= "&amp;" . NV_OP_VARIABLE . "=subject/" . $nv_laws_listsubject[$catid]['alias'];

if ($page > 1) {
    $page_url .= '/page-' . $page;
}

$canonicalUrl = getCanonicalUrl($page_url);


if (!defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $order = ($nv_laws_setting['typeview'] == 1) ? "ASC" : "DESC";

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE status=1 AND sid=" . $catid . " ORDER BY addtime " . $order . " LIMIT " . $per_page . " OFFSET " . ($page - 1) * $per_page;
    $result = $db->query($sql);
    $query = $db->query("SELECT FOUND_ROWS()");
    $all_page = $query->fetchColumn();

    betweenURLs($page, ceil($all_page/$per_page), $base_url, '/page-', $prevPage, $nextPage);

    $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
    $array_data = raw_law_list_by_result($result, $page, $per_page);
    $contents = nv_theme_laws_subject($array_data, $generate_page, $nv_laws_listsubject[$catid]);

    if (!defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
