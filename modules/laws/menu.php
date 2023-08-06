<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_cat ORDER BY parentid, weight ASC';
$result = $db->query($sql);
While ($row = $result->fetch()) {
    $array_item[$row['id']] = [
        'parentid' => $row['parentid'],
        'key' => $row['id'],
        'title' => $row['title'],
        'alias' => $row['alias']
    ];
}
