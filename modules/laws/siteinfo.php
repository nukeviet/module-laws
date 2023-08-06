<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    die('Stop!!!');
}

$lang_siteinfo = nv_get_lang_module($mod);

// Tong so bai viet
$number = $db->query("SELECT COUNT(*) as number FROM " . NV_PREFIXLANG . "_" . $mod_data . "_row")->fetchColumn();
if ($number > 0) {
    $siteinfo[] = [
        'key' => $lang_siteinfo['siteinfo_numlaws'],
        'value' => $number
    ];
}
