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

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];
$page_url = $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;

$page = 1;
if (isset($array_op[0]) and preg_match('/^page\-([0-9]{1,10})$/', $array_op[0], $m)) {
    $page = intval($m[1]);
}

$contents = $cache_file = '';
$per_page = $nv_laws_setting['nummain'];

if (!defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file, 3600)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    if ($nv_laws_setting['typeview'] != 2) {
        // Danh sách văn bản dạng list, có phân trang
        $order = ($nv_laws_setting['typeview'] == 1 or $nv_laws_setting['typeview'] == 4) ? "ASC" : "DESC";
        $order_param = ($nv_laws_setting['typeview'] == 0 or $nv_laws_setting['typeview'] == 1) ? (defined('ACTIVE_COMMENTS') ? 'start_comm_time' : 'publtime') : "addtime";

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE status=1 ORDER BY " . $order_param . " " . $order . "
        LIMIT " . $per_page . " OFFSET " . (($page - 1) * $per_page);

        $result = $db->query($sql);
        $query = $db->query("SELECT FOUND_ROWS()");
        $all_page = $query->fetchColumn();

        betweenURLs($page, ceil($all_page / $per_page), $base_url, '/page-', $prevPage, $nextPage);

        $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
        $array_data = raw_law_list_by_result($result, $page, $per_page);

        if ($page > 1) {
            if (empty($array_data)) {
                nv_redirect_location($base_url);
            } else {
                $page_url .= '&amp;' . NV_OP_VARIABLE . '=page-' . $page;
            }
        }

        $canonicalUrl = getCanonicalUrl($page_url);

        $contents = nv_theme_laws_main($array_data, $generate_page);
    } else {
        // Văn bản phân theo cơ quan ban hành, không phân trang
        $canonicalUrl = getCanonicalUrl($page_url);
        if (!empty($nv_laws_listsubject)) {
            foreach ($nv_laws_listsubject as $subjectid => $subject) {
                $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $subjectid . ' AND status=1 ORDER BY addtime DESC LIMIT ' . $subject['numlink']);
                $nv_laws_listsubject[$subjectid]['rows'] = raw_law_list_by_result($result);
            }
        }
        $contents = nv_theme_laws_maincat('subject', $nv_laws_listsubject);
    }

    if (!defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
        $nv_Cache->setItem($module_name, $cache_file, $contents, 3600);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
