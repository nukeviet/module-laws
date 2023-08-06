<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_SEARCH')) {
    die('Stop!!!');
}

$sql = 'SELECT SQL_CALC_FOUND_ROWS id,title,alias,bodytext
FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_row
WHERE status=1 AND (' . nv_like_logic('title', $dbkeyword, $logic) . '
OR ' . nv_like_logic('bodytext', $dbkeyword, $logic) . ')
LIMIT ' . ($page - 1) * $limit . ',' . $limit;

$tmp_re = $db->query($sql);

$result = $db->query('SELECT FOUND_ROWS()');
$num_items = $result->fetchColumn();

if ($num_items) {
    $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=' . $site_mods[$m_values['module_name']]['alias']['detail'] . '/';

    while (list($id, $tilterow, $alias, $content) = $tmp_re->fetch(3)) {
        $result_array[] = [
            'link' => $link . $alias,
            'title' => BoldKeywordInStr($tilterow, $key, $logic),
            'content' => BoldKeywordInStr($content, $key, $logic)
        ];
    }
}
