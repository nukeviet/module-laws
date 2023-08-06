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

$debug = false;

if ($debug) {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_area (
        id, parentid, alias, title, introduction, keywords, addtime, weight, sort, lev, numsubcat, subcatid
    ) VALUES
        (1, 0, 'Giao-duc-1', 'Giáo dục', '', '', 1412265295, 1, 1, 0, 2, ''),
        (3, 1, 'dai-hoc', 'Đại học', '', '', 1412265295, 1, 2, 1, 0, '3,4'),
        (4, 1, 'thpt', 'Trung học phổ thông', '', '', 1412265295, 2, 3, 1, 0, ''),
        (2, 0, 'Phap-quy-2', 'Pháp quy', '', '', 1412265295, 2, 4, 0, 0, '')");
} else {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_area (
        id, parentid, alias, title, introduction, keywords, addtime, weight, sort, lev, numsubcat, subcatid
    ) VALUES
        (1, 0, 'Giao-duc-1', 'Giáo dục', '', '', 1412265295, 1, 1, 0, 0, ''),
        (2, 0, 'Phap-quy-2', 'Pháp quy', '', '', 1412265295, 2, 2, 0, 0, '')");
}

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat VALUES
    (1, 0, 'Cong-van', 'Công văn', '', '', 5, 1412265295, 1),
    (2, 0, 'Thong-tu', 'Thông tư', '', '', 5, 1412265295, 2),
    (3, 0, 'Quyet-dinh', 'Quyết định', '', '', 5, 1412265295, 3),
    (4, 0, 'Nghi-dinh', 'Nghị định', '', '', 5, 1412265295, 4),
    (5, 0, 'Thong-bao', 'Thông báo', '', '', 5, 1412998152, 5),
    (6, 0, 'Huong-dan', 'Hướng dẫn', '', '', 5, 1412998170, 6),
    (7, 0, 'Bao-cao', 'Báo cáo', '', '', 5, 1412998182, 7),
    (8, 0, 'Chi-thi', 'Chỉ thị', '', '', 5, 1412998193, 8),
    (9, 0, 'Ke-hoach', 'Kế hoạch', '', '', 5, 1412998208, 9)");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer VALUES
    (1, 'Phạm Vũ Luận', '', 'Bộ trưởng', 1412265295),
    (2, 'Bùi Văn Ga', '', 'Thứ trưởng', 1412265295),
    (3, 'Nguyễn Thị Nghĩa', '', 'Thứ trưởng', 1412265295),
    (4, 'Nguyễn Vinh Hiển', '', 'Thứ trưởng', 1412265295),
    (5, 'Khác', '', '', 1412265295)");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject VALUES
    (1, 'Bo-GD-DT', 'Bộ GD&amp;ĐT', '', '', 0, 5, 1412265295, 1),
    (2, 'So-GD-DT', 'Sở GD&amp;ĐT', '', '', 0, 5, 1412265295, 2),
    (3, 'Phong-GD-DT', 'Phòng GD', '', '', 0, 5, 1412265295, 3),
    (4, 'Khac', 'Khác', '', '', 0, 5, 1412265295, 4)");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_examine VALUES
    (1, 'Ủy ban Pháp luật', 1),
    (2, 'Ủy ban Đối ngoại', 2),
    (3, 'Ủy ban Kinh tế', 3),
    (4, 'Ủy ban Tư pháp', 4)");

if ($debug) {
    for ($i = 1; $i < 101; $i++) {
        $row['id'] = $i;
        $row['title'] = $db->quote('Văn bản ' . $i);
        $row['alias'] = $db->quote('vanban' . $i);
        $row['code'] = $db->quote('VB' . $i);
        $row['cid'] = random_int(1, 9);
        $row['sid'] = random_int(1, 4);
        $row['eid'] = random_int(1, 4);
        $row['sgid'] = random_int(1, 5);
        $row['note'] = "''";
        $row['introtext'] = "''";
        $row['bodytext'] = "''";
        $row['keywords'] = "''";
        $row['groups_view'] = "'6'";
        $row['groups_download'] = "'6'";
        $row['files'] = "''";
        $row['status'] = 1;
        $row['approval'] = 1;

        $offset = random_int(0, 100);

        $row['exptime'] = $offset == 0 ? 0 : (time() + ($offset * 86400));
        $row['addtime'] = time() - ($offset * 86400) - 86400;
        $row['edittime'] = time() - ($offset * 86400) - 86400;
        $row['publtime'] = time() - ($offset * 86400) - 86400;
        $row['start_comm_time'] = time() - ($offset * 86400) - 86400;
        $row['end_comm_time'] = time() + ($offset * 86400) + 86400;
        $row['admin_add'] = 1;
        $row['view_hits'] = random_int(0, 10000);

        $area_id = random_int(1, 4);
        $row['area_ids'] = "'" . $area_id . "'";

        $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row (" . implode(',', array_keys($row)) . ") VALUES (" . implode(',', $row) . ")");
        $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row_area (row_id, area_id) VALUES (" . $i . ", " . $area_id . ")");
    }
}
