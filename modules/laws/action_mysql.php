<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 27 Jul 2011 14:55:22 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$sql_drop_module = [];
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_area";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row_area";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_set_replace";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_examine";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_area(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  alias varchar(249) NOT NULL,
  title varchar(249) NOT NULL,
  introduction mediumtext NOT NULL,
  keywords varchar(255) NOT NULL,
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  sort smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Thứ tự tổng thể',
  lev tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp bậc',
  numsubcat tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Số lĩnh vực con',
  subcatid varchar(255) NOT NULL DEFAULT '' COMMENT 'Danh sách ID lĩnh vực con, phân cách bởi dấu phảy',
  PRIMARY KEY (id),
  UNIQUE KEY alias (alias,parentid),
  KEY weight (weight),
  KEY sort (sort)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  alias varchar(249) NOT NULL,
  title varchar(249) NOT NULL,
  introduction mediumtext NOT NULL,
  keywords varchar(255) NOT NULL,
  newday tinyint(2) unsigned NOT NULL DEFAULT '5',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY alias (alias,parentid),
  KEY weight (weight)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  alias varchar(250) NOT NULL,
  title varchar(250) NOT NULL,
  introduction mediumtext NOT NULL,
  keywords varchar(255) NOT NULL,
  numcount int(10) NOT NULL DEFAULT '0',
  numlink tinyint(2) NOT NULL DEFAULT '5',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY alias (alias),
  KEY weight (weight)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row(
  id int(10) NOT NULL AUTO_INCREMENT,
  replacement varchar(255) NOT NULL DEFAULT '',
  relatement varchar(255) NOT NULL DEFAULT '',
  title varchar(255) NOT NULL,
  alias varchar(255) NOT NULL,
  code varchar(50) NOT NULL,
  area_ids varchar(191) NOT NULL DEFAULT '' COMMENT 'Danh sách lĩnh vực phân cách bởi dấu phảy',
  cid smallint(4) unsigned NOT NULL DEFAULT '0',
  sid smallint(4) unsigned NOT NULL DEFAULT '0',
  eid smallint(4) unsigned NOT NULL DEFAULT '0',
  sgid smallint(4) unsigned NOT NULL DEFAULT '0',
  note text NOT NULL,
  introtext text NOT NULL,
  bodytext text NOT NULL,
  keywords varchar(255) NOT NULL,
  groups_view varchar(255) NOT NULL,
  groups_download varchar(255) NOT NULL,
  files mediumtext NOT NULL,
  status tinyint(1) NOT NULL,
  approval tinyint(1) NOT NULL,
  addtime int(11) NOT NULL,
  edittime int(11) NOT NULL,
  publtime int(11) NOT NULL DEFAULT '0',
  start_comm_time int(11) NULL,
  end_comm_time int(11) NULL,
  startvalid int(11) NOT NULL DEFAULT '0',
  exptime int(11) NOT NULL DEFAULT '0',
  view_hits mediumint(8) unsigned NOT NULL DEFAULT '0',
  download_hits mediumint(8) unsigned NOT NULL DEFAULT '0',
  admin_add mediumint(8) unsigned NOT NULL DEFAULT '0',
  admin_edit mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY area_ids (area_ids),
  KEY cid (cid),
  KEY sid (sid),
  KEY eid (eid),
  KEY sgid (sgid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_row_area (
    row_id INT(10) UNSIGNED NOT NULL ,
    area_id SMALLINT(4) UNSIGNED NOT NULL,
    UNIQUE KEY alias (row_id, area_id)
) ENGINE = MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  offices varchar(255) NOT NULL DEFAULT '',
  positions varchar(255) NOT NULL DEFAULT '',
  addtime int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_set_replace (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  oid mediumint(8) unsigned NOT NULL DEFAULT '0',
  nid mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
  config_name varchar(30) NOT NULL,
  config_value varchar(255) NOT NULL,
  UNIQUE KEY config_name (config_name)
)ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_examine(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins(
  userid mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  subjectid smallint(4) NOT NULL DEFAULT '0',
  areaid smallint(4) unsigned NOT NULL DEFAULT '0',
  admin tinyint(4) NOT NULL DEFAULT '0',
  add_content tinyint(4) NOT NULL DEFAULT '0',
  edit_content tinyint(4) NOT NULL DEFAULT '0',
  del_content tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY userid (userid,subjectid,areaid)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config VALUES
('nummain', '50'),
('numsub', '50'),
('typeview', '0'),
('down_in_home', '1'),
('detail_other', 'a:1:{i:0;s:3:\"cat\";}'),
('detail_hide_empty_field', '1'),
('detail_show_link_cat', '1'),
('detail_show_link_area', '1'),
('detail_show_link_subject', '1'),
('detail_show_link_signer', '1'),
('detail_pdf_quick_view', '1'),
('other_numlinks', '5'),
('title_show_type', '0')
";

// Comments
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'auto_postcomm', '0')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha_area_comm', '1')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha_type_comm', 'captcha')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_comm', '6')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_comm', '6')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'setcomm', '4')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'activecomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'emailcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'adminscomm', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'sortcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'perpagecomm', '5')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'timeoutcomm', '360')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowattachcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'alloweditorcomm', '0')";
