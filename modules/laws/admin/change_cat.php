<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$catid = $nv_Request->get_int('catid', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
$content = 'NO_' . $catid;

list ($catid) = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE id=' . $catid)->fetch(3);
if ($catid > 0) {
    if ($mod == 'numlinks' and $new_vid >= 0 and $new_vid <= 20) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET numlink=' . $new_vid . ' WHERE id=' . $catid;
        $db->query($sql);
        $content = 'OK';
    }
    $nv_Cache->delMod($module_name);
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';
