<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_SITEMAP')) {
    die('Stop!!!');
}

if (!nv_function_exists('catalog_laws_viewsub')) {
    function catalog_laws_viewsub($list_sub)
    {
        global $db_config, $db, $site_mods, $mName;

        $sublinks_i = [];

        if (empty($list_sub))
            return "";
        else {
            $sql = "SELECT id, parentid, title, alias FROM " . NV_PREFIXLANG . "_" . $site_mods[$mName]['module_data'] . "_cat WHERE id IN(" . implode(',', $list_sub) . ") ORDER BY weight ASC";
            $result = $db->query($sql);
            while ($row = $result->fetch()) {
                $row['subcatid'] = [];
                $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$mName]['module_data'] . "_cat WHERE parentid = " . $row['id'] . " ORDER BY weight ASC";
                $sub = $db->query($sql);
                while ($subrow = $sub->fetch()) {
                    $row['subcatid'][] = $subrow['id'];
                }

                $array_sub = (!empty($row['subcatid'])) ? catalog_laws_viewsub($row['subcatid']) : [];
                $sublinks_i[] = array(
                    'title' => $row['title'],
                    'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $mName . "/" . $row['alias'],
                    'subs' => $array_sub
                );
            }
            return $sublinks_i;
        }
    }
}

$sublinks = [];

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$mName]['module_data'] . "_cat WHERE parentid = 0 ORDER BY weight ASC";
$result = $db->query($sql);

while ($row = $result->fetch()) {
    $row['subcatid'] = [];
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$mName]['module_data'] . "_cat WHERE parentid = " . $row['id'] . " ORDER BY weight ASC";
    $sub = $db->query($sql);
    while ($subrow = $sub->fetch()) {
        $row['subcatid'][] = $subrow['id'];
    }

    $array_sub = (!empty($row['subcatid'])) ? catalog_laws_viewsub($row['subcatid']) : [];
    $sublinks[] = array(
        'title' => $row['title'],
        'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $mName . "/" . $row['alias'],
        'subs' => $array_sub
    );
}
