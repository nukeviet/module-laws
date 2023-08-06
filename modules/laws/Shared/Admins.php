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
class Admins
{
    const TYPE_SUBJECT = 0; // Quản lý văn bản theo cơ quan ban hành
    const TYPE_AREA = 1; // Quản lý văn bản theo lĩnh vực
    const TYPE_ADMIN = 2; // Admin module
    const TYPE_FULL = 3; // Toàn quyền module
}
