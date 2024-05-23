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
class QuickViews
{
    /**
     * @var string Kiểu file PDF
     */
    const TYPE_PDF = 'pdf';

    /**
     * @var string Kiểu file PDF
     */
    const TYPE_OFFICE = 'ms';

    /**
     * @var string Kiểu file PDF
     */
    const TYPE_IMAGE = 'image';

    /**
     * @var string Kiểu file khác
     */
    const TYPE_OTHER = 'o';

    const DATA = [
        'pdf' => 'pdf',
        // Word
        'docx' => 'word',
        'doc' => 'word',
        'dotx' => 'word',
        'dot' => 'word',
        'dotm' => 'word',
        'docm' => 'word',
        'odt' => 'word',
        // Excel
        'xlsx' => 'excel',
        'xls' => 'excel',
        'xlsm' => 'excel',
        'xlsb' => 'excel',
        'xltx' => 'excel',
        'xltm' => 'excel',
        'csv' => 'excel',
        'ods' => 'excel',
        // PowerPoint
        'pptx' => 'powerpoint',
        'ppt' => 'powerpoint',
        'ppsx' => 'powerpoint',
        'pps' => 'powerpoint',
        'potx' => 'powerpoint',
        'pot' => 'powerpoint',
        'potm' => 'powerpoint',
        'ppsm' => 'powerpoint',
        'odp' => 'powerpoint',
        // Image
        'jpg' => 'image',
        'png' => 'image',
        'gif' => 'image',
        'webp' => 'image',
        'jpeg' => 'image',
    ];

    /**
     * @return array
     */
    public static function allTypes()
    {
        return [
            self::TYPE_PDF,
            self::TYPE_OFFICE,
            self::TYPE_IMAGE
        ];
    }

    /**
     * @param string $ext Đuôi file cần kiểm tra, cần được lowercase trước
     * @return string|mixed
     */
    public static function canPreview(?string $ext)
    {
        $type2key = [
            'pdf' => self::TYPE_PDF,
            'word' => self::TYPE_OFFICE,
            'excel' => self::TYPE_OFFICE,
            'powerpoint' => self::TYPE_OFFICE,
            'image' => self::TYPE_IMAGE
        ];
        return $type2key[self::DATA[$ext] ?? ''] ?? '';
    }

    /**
     * @param string $ext
     * @return string
     */
    public static function typeFile(?string $ext)
    {
        return self::DATA[$ext] ?? '';
    }
}
