<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

use NukeViet\Module\laws\Shared\Admins;

global $module_config, $array_subject_admin, $admin_id, $array_area_admin, $array_configed_admin;

if (!function_exists('nv_laws_get_admins')) {
    /**
     * @param string $module_data
     * @return array
     */
    function nv_laws_get_admins($module_data)
    {
        global $db_slave;

        $array_subject_admin = $array_area_admin = $array_configed_admin = [];
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);

        while ($row = $result->fetch()) {
            if (!empty($row['areaid'])) {
                $array_area_admin[$row['userid']][$row['areaid']] = $row;
            } else {
                $array_subject_admin[$row['userid']][$row['subjectid']] = $row;
            }
            $array_configed_admin[$row['userid']] = $row['userid'];
        }

        return [$array_subject_admin, $array_area_admin, $array_configed_admin];
    }
}

$is_refresh = false;
list($array_subject_admin, $array_area_admin, $array_configed_admin) = nv_laws_get_admins($module_data);

if (!empty($module_info['admins'])) {
    $module_admin = explode(',', $module_info['admins']);
    foreach ($module_admin as $userid_i) {
        if (!isset($array_configed_admin[$userid_i])) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (
                userid, subjectid, admin, add_content, edit_content, del_content
            ) VALUES (
                ' . $userid_i . ', 0, ' . Admins::TYPE_ADMIN . ', 1, 1, 1
            )');
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    list($array_subject_admin, $array_area_admin, $array_configed_admin) = nv_laws_get_admins($module_data);
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if (defined('NV_IS_SPADMIN')) {
    $NV_IS_ADMIN_MODULE = true;
    $NV_IS_ADMIN_FULL_MODULE = true;
} else {
    if (isset($array_subject_admin[$admin_id][0])) {
        $NV_IS_ADMIN_MODULE = true;
        if (intval($array_subject_admin[$admin_id][0]['admin']) == Admins::TYPE_FULL) {
            $NV_IS_ADMIN_FULL_MODULE = true;
        }
    }
}

if ($NV_IS_ADMIN_MODULE) {
    $submenu['signer'] = $nv_Lang->getModule('signer');
    $submenu['area'] = $nv_Lang->getModule('area');
    $submenu['cat'] = $nv_Lang->getModule('cat');
    $submenu['subject'] = $nv_Lang->getModule('subject');
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    $submenu['admins'] = $nv_Lang->getModule('admins');
    $submenu['config'] = $nv_Lang->getModule('config');
}
if ($module_config[$module_name]['activecomm'] and $NV_IS_ADMIN_MODULE) {
    $submenu['examine'] = $nv_Lang->getModule('examine');
}
