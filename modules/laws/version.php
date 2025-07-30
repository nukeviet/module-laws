<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = [
    'name' => 'Laws',
    'modfuncs' => 'main,detail,search,area,cat,subject,signer',
    'submenu' => 'main,detail,search,area,cat,subject,signer',
    'change_alias' => 'detail',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '5.0.00',
    'date' => 'Wednesday, July 30, 2025 8:18:35 AM GMT+07:00',
    'author' => 'VINADES <contact@vinades.vn>',
    'uploads_dir' => [
        $module_upload
    ],
    'note' => 'Modules văn bản pháp luật'
];
