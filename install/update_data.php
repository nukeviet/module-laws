<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2012 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (!defined('NV_IS_UPDATE'))
    die('Stop!!!');

$nv_update_config = array();

// Kieu nang cap 1: Update; 2: Upgrade
$nv_update_config['type'] = 1;

// ID goi cap nhat
$nv_update_config['packageID'] = 'NVULAWS4502';

// Cap nhat cho module nao, de trong neu la cap nhat NukeViet, ten thu muc module neu la cap nhat module
$nv_update_config['formodule'] = 'laws';

// Thong tin phien ban, tac gia, ho tro
$nv_update_config['release_date'] = 1664249620;
$nv_update_config['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$nv_update_config['support_website'] = 'https://github.com/nukeviet/module-laws/tree/to-4.5.02';
$nv_update_config['to_version'] = '4.5.02';
$nv_update_config['allow_old_version'] = array('4.1.02', '4.2.01', '4.2.02', '4.3.00', '4.3.01', '4.3.05', '4.5.00');

// 0:Nang cap bang tay, 1:Nang cap tu dong, 2:Nang cap nua tu dong
$nv_update_config['update_auto_type'] = 1;

$nv_update_config['lang'] = array();
$nv_update_config['lang']['vi'] = array();

// Tiếng Việt
$nv_update_config['lang']['vi']['nv_up_s1'] = 'Thêm chức năng bình luận';
$nv_update_config['lang']['vi']['nv_up_s2'] = 'Thêm chức năng ủy ban thẩm tra';
$nv_update_config['lang']['vi']['nv_up_s3'] = 'Sửa dữ liệu văn bản';
$nv_update_config['lang']['vi']['nv_up_s4'] = 'Cập nhật CSDL phiên bản 4.3.01';
$nv_update_config['lang']['vi']['nv_up_s5'] = 'Cập nhật CSDL phiên bản 4.3.05';
$nv_update_config['lang']['vi']['nv_up_s6'] = 'Cập nhật CSDL phiên bản 4.5.00';
$nv_update_config['lang']['vi']['nv_up_finish'] = 'Đánh dấu phiên bản mới';

$nv_update_config['tasklist'] = array();
$nv_update_config['tasklist'][] = array(
    'r' => '4.3.00',
    'rq' => 1,
    'l' => 'nv_up_s1',
    'f' => 'nv_up_s1'
);
$nv_update_config['tasklist'][] = array(
    'r' => '4.3.00',
    'rq' => 1,
    'l' => 'nv_up_s2',
    'f' => 'nv_up_s2'
);
$nv_update_config['tasklist'][] = array(
    'r' => '4.3.00',
    'rq' => 1,
    'l' => 'nv_up_s3',
    'f' => 'nv_up_s3'
);
$nv_update_config['tasklist'][] = array(
    'r' => '4.3.01',
    'rq' => 1,
    'l' => 'nv_up_s4',
    'f' => 'nv_up_s4'
);
$nv_update_config['tasklist'][] = array(
    'r' => '4.3.05',
    'rq' => 1,
    'l' => 'nv_up_s5',
    'f' => 'nv_up_s5'
);
$nv_update_config['tasklist'][] = array(
    'r' => '4.5.00',
    'rq' => 1,
    'l' => 'nv_up_s6',
    'f' => 'nv_up_s6'
);

$nv_update_config['tasklist'][] = array(
    'r' => '4.5.02',
    'rq' => 1,
    'l' => 'nv_up_finish',
    'f' => 'nv_up_finish'
);

// Danh sach cac function
/*
Chuan hoa tra ve:
array(
'status' =>
'complete' =>
'next' =>
'link' =>
'lang' =>
'message' =>
);
status: Trang thai tien trinh dang chay
- 0: That bai
- 1: Thanh cong
complete: Trang thai hoan thanh tat ca tien trinh
- 0: Chua hoan thanh tien trinh nay
- 1: Da hoan thanh tien trinh nay
next:
- 0: Tiep tuc ham nay voi "link"
- 1: Chuyen sang ham tiep theo
link:
- NO
- Url to next loading
lang:
- ALL: Tat ca ngon ngu
- NO: Khong co ngon ngu loi
- LangKey: Ngon ngu bi loi vi,en,fr ...
message:
- Any message
Duoc ho tro boi bien $nv_update_baseurl de load lai nhieu lan mot function
Kieu cap nhat module duoc ho tro boi bien $old_module_version
*/

$array_modlang_update = array();
$array_modtable_update = array();

// Lay danh sach ngon ngu
$result = $db->query("SELECT lang FROM " . $db_config['prefix'] . "_setup_language WHERE setup=1");
while (list($_tmp) = $result->fetch(PDO::FETCH_NUM)) {
    $array_modlang_update[$_tmp] = array("lang" => $_tmp, "mod" => array());

    // Get all module
    $result1 = $db->query("SELECT title, module_data FROM " . $db_config['prefix'] . "_" . $_tmp . "_modules WHERE module_file=" . $db->quote($nv_update_config['formodule']));
    while (list($_modt, $_modd) = $result1->fetch(PDO::FETCH_NUM)) {
        $array_modlang_update[$_tmp]['mod'][] = array("module_title" => $_modt, "module_data" => $_modd);
        $array_modtable_update[] = $db_config['prefix'] . "_" . $_tmp . "_" . $_modd;
    }
}

/**
 * nv_up_s1()
 *
 * @return
 *
 */
function nv_up_s1()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );
    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $db->query("INSERT INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'view_comm', '6'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'allowed_comm', '6'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'auto_postcomm', '0'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'setcomm', '4'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'activecomm', '0'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'emailcomm', '0'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'adminscomm', ''),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'sortcomm', '0'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'captcha', '1'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'perpagecomm', '5'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'timeoutcomm', '360'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'allowattachcomm', '360'),
                    ('" . $lang . "', '" . $module_info['module_title'] . "', 'alloweditorcomm', '360');
                ");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }
    return $return;
}

/**
 * nv_up_s2()
 *
 * @return
 *
 */
function nv_up_s2()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );
    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $db->query("CREATE TABLE IF NOT EXISTS `" . $table_prefix . "_examine` (
                  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
                  `title` varchar(255) NOT NULL,
                  `weight` smallint(4) NOT NULL,
                  PRIMARY KEY (id)
                ) ENGINE=MyISAM;");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }
    return $return;
}

/**
 * nv_up_s3()
 *
 * @return
 *
 */
function nv_up_s3()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );
    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_row` ADD `start_comm_time` INT(11) NULL AFTER `publtime`;");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_row` ADD `end_comm_time` INT(11) NULL AFTER `start_comm_time`;");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_row` ADD `eid` INT(11) NULL DEFAULT '0' AFTER `sid`;");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_row` ADD `approval` TINYINT(1) NOT NULL DEFAULT '0' AFTER `status`;");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }
    return $return;
}

/**
 * nv_up_s4()
 *
 * @return
 *
 */
function nv_up_s4()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );

    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $sql = "CREATE TABLE " . $table_prefix . "_admins(
                    userid mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
                    subjectid smallint(4) NOT NULL DEFAULT '0',
                    admin tinyint(4) NOT NULL DEFAULT '0',
                    add_content tinyint(4) NOT NULL DEFAULT '0',
                    edit_content tinyint(4) NOT NULL DEFAULT '0',
                    del_content tinyint(4) NOT NULL DEFAULT '0',
                    UNIQUE KEY userid (userid,subjectid)
                ) ENGINE=MyISAM";
                $db->query($sql);
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }

    return $return;
}


/**
 * nv_up_s5()
 *
 * @return
 *
 */
function nv_up_s5()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );

    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $sql = "INSERT INTO " . $table_prefix . "_config (
                        config_name, config_value
                    ) VALUES (
                        'title_show_type', '0'
                    )";
                $db->query($sql);

            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }

    return $return;
}


/**
 * nv_up_s6()
 *
 * @return
 *
 */
function nv_up_s6()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $array_modlang_update;
    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );
    foreach ($array_modlang_update as $lang => $array_mod) {
        foreach ($array_mod['mod'] as $module_info) {
            try {
                $sql = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (
                        lang, module, config_name, config_value
                    ) VALUES (
                        '" . $lang . "', '" . $module_info['module_data'] . "', 'captcha_area_comm', '1'
                    )";
                $db->query($sql);

            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
            try {
                $sql = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (
                        lang, module, config_name, config_value
                    ) VALUES (
                        '" . $lang . "', '" . $module_info['module_data'] . "', 'captcha_type_comm', 'captcha'
                    )";
                $db->query($sql);

            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }

            $table_prefix = $db_config['prefix'] . "_" . $lang . "_" . $module_info['module_data'];
            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_area` ADD `subcatid` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Danh sách ID lĩnh vực con, phân cách bởi dấu phảy' AFTER `weight`;");
                $db->query("ALTER TABLE `" . $table_prefix . "_area` ADD `numsubcat` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Số lĩnh vực con' AFTER `weight`;");
                $db->query("ALTER TABLE `" . $table_prefix . "_area` ADD `lev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp bậc' AFTER `weight`;");
                $db->query("ALTER TABLE `" . $table_prefix . "_area` ADD `sort` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Thứ tự tổng thể' AFTER `weight`;");
                $db->query("CREATE INDEX weight ON " . $table_prefix . "_area` (weight);");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }

            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_row` ADD `area_ids` varchar(191) NOT NULL DEFAULT '' COMMENT 'Danh sách lĩnh vực phân cách bởi dấu phảy' AFTER `code`;");
                $db->query("CREATE INDEX sgid ON `" . $table_prefix . "_row` (sgid);");
                $db->query("CREATE INDEX eid ON `" . $table_prefix . "_row` (eid);");
                $db->query("CREATE INDEX sid ON `" . $table_prefix . "_row` (sid);");
                $db->query("CREATE INDEX cid ON `" . $table_prefix . "_row` (cid);");
                $db->query("CREATE INDEX area_ids ON `" . $table_prefix . "_row` (area_ids);");
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }

            try {
                $db->query("ALTER TABLE `" . $table_prefix . "_admins` ADD `areaid` smallint(4) unsigned NOT NULL DEFAULT '0';");
                $db->query("DROP INDEX userid ON `" . $table_prefix . "_admins`;");
                $db->query("ALTER TABLE `" . $table_prefix . "_admins` ADD CONSTRAINT userid UNIQUE (userid,subjectid,areaid);");
               
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }


        }
    }

    return $return;
}

/**
 * nv_up_finish()
 *
 * @return
 *
 */
function nv_up_finish()
{
    global $nv_update_baseurl, $db, $db_config, $nv_Cache, $nv_update_config;

    $return = array(
        'status' => 1,
        'complete' => 1,
        'next' => 1,
        'link' => 'NO',
        'lang' => 'NO',
        'message' => ''
    );

    @nv_deletefile(NV_ROOTDIR . '/modules/laws/blocks/.htaccess');
    @nv_deletefile(NV_ROOTDIR . '/modules/laws/funcs/.htaccess');
    @nv_deletefile(NV_ROOTDIR . '/modules/laws/language/.htaccess');

    try {
        $num = $db->query("SELECT COUNT(*) FROM " . $db_config['prefix'] . "_setup_extensions WHERE basename='" . $nv_update_config['formodule'] . "' AND type='module'")->fetchColumn();
        $version = $nv_update_config['to_version'] . " " . $nv_update_config['release_date'];

        if (!$num) {
            $db->query("INSERT INTO " . $db_config['prefix'] . "_setup_extensions (
                id, type, title, is_sys, is_virtual, basename, table_prefix, version, addtime, author, note
            ) VALUES (
                254, 'module', '". $nv_update_config['formodule'] ."', 0, 1, '". $nv_update_config['formodule'] ."', '". $nv_update_config['formodule'] ."', '" . $nv_update_config['to_version'] . " " . $nv_update_config['release_date'] . "', " . NV_CURRENTTIME . ", '" . $nv_update_config['author'] . "',
                'Modules văn bản pháp luật'
            )");
        } else {
            $db->query("UPDATE " . $db_config['prefix'] . "_setup_extensions SET
                id=254,
                version='" . $version . "',
                author='" . $nv_update_config['author'] . "'
            WHERE basename='" . $nv_update_config['formodule'] . "' AND type='module'");
        }
    } catch (PDOException $e) {
        trigger_error($e->getMessage());
    }

    $nv_Cache->delAll(true);
    return $return;
}
