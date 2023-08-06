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

if (!function_exists('nv_law_block_singer')) {
    /**
     * @return string
     */
    function nv_law_block_singer()
    {
        global $module_info, $module_file, $global_config, $nv_laws_listsubject, $module_name, $db, $module_data, $nv_Lang;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/block_signer.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate("block_signer.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('MODULE_FILE', $module_file);

        $title_length = 24;

        $html = "";
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer ORDER BY RAND() LIMIT 10";

        $result = $db->query($sql);

        while ($cat = $result->fetch()) {
            $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=signer/" . $cat['id'] . "/" . change_alias($cat['title']);
            $html .= "<li>\n";
            $html .= "<a title=\"" . $cat['title'] . "\" href=\"" . $link . "\"><span class=\"small-icon snumc\">&nbsp;</span>" . nv_clean60($cat['title'], $title_length) . "</a>\n";
            $html .= "</li>\n";
        }

        $xtpl->assign('CONTENT', $html);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_law_block_singer();
}
