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

$channel = [];
$items = [];

$channel['title'] = $global_config['site_name'] . ' RSS: ' . $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;
$channel['atomlink'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=rss";
$channel['description'] = $global_config['site_description'];

if (!empty($nv_laws_listcat)) {
    $catalias = isset($array_op[1]) ? $array_op[1] : "";
    $cid = 0;

    if (!empty($catalias)) {
        foreach ($nv_laws_listcat as $c) {
            if ($c['alias'] == $catalias) {
                $cid = $c['id'];
                break;
            }
        }
    }

    if ($cid > 0) {
        $channel['title'] = $global_config['site_name'] . ' RSS: ' . $module_info['custom_title'] . ' - ' . $nv_laws_listcat[$cid]['title'];
        $channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;cat=" . $nv_laws_listcat[$cid]['alias'];
        $channel['description'] = $nv_laws_listcat[$cid]['introduction'];

        $sql = "SELECT id, title, code, alias, introtext, addtime, publtime
        FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE cid=" . $cid . "
        AND status=1 ORDER BY addtime DESC LIMIT 30";
    } else {
        $in = array_keys($nv_laws_listcat);
        $in = implode(",", $in);
        $sql = "SELECT id, title, code, alias, introtext, addtime, publtime
        FROM " . NV_PREFIXLANG . "_" . $module_data . "_row WHERE cid IN (" . $in . ")
        AND status=1 ORDER BY addtime DESC LIMIT 30";
    }
    if ($module_info['rss']) {
        if (($result = $db->query($sql)) !== false) {
            while (list ($id, $title, $code, $alias, $introtext, $addtime, $publtime) = $result->fetch(3)) {
                $items[] = [
                    'title' => '[' . $code . '] ' . $title,
                    'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=detail/" . $alias,
                    'guid' => $module_name . '_' . $id,
                    'description' => $nv_Lang->getModule('publtime') . ': ' . nv_date('d/m/Y', $publtime) . '. ' . $nv_Lang->getModule('introtext') . ': ' . $introtext,
                    'pubdate' => $addtime
                ];
            }
        }
    }
}

$atomlink = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'];
nv_rss_generate($channel, $items, $atomlink);
die();
