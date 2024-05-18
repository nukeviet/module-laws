<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace NukeViet\Module\laws\Shared;

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

/**
 * @author VINADES.,JSC <contact@vinades.vn>
 *
 */
class Laws
{
    /**
     * @param array $row
     * @return string
     */
    public static function getStatus($row)
    {
        global $nv_Lang;

        if (defined('ACTIVE_COMMENTS')) {
            // Trạng thái trong trường hợp lấy ý kiến dự thảo
            if (!isset($row['approval'])) {
                return '####';
            }

            return $nv_Lang->getModule('e' . $row['approval']);
        }

        // Trạng thái trong văn bản thường
        if (!isset($row['effective_status'], $row['startvalid'], $row['exptime'])) {
            return '####';
        }

        if ($row['effective_status'] > 0) {
            return $nv_Lang->getModule('effective_status' . $row['effective_status']);
        }
        if (!empty($row['exptime']) and $row['exptime'] < NV_CURRENTTIME) {
            // Hết hiệu lực
            return $nv_Lang->getModule('hl1');
        }
        if (!empty($row['startvalid'])) {
            // Còn hiệu lực hoặc chưa hiệu lực
            return $nv_Lang->getModule($row['startvalid'] > NV_CURRENTTIME ? 'hl0' : 'hl2');
        }
        // Đã biết
        return $nv_Lang->getModule('effective_status0');
    }
}
