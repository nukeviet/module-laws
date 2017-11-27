# Module laws

Văn bản pháp quy

```
#lệnh thêm bảng nv4_vi_laws_admins
CREATE TABLE `nv4_vi_laws_admins` (
  `userid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `catid` smallint(5) NOT NULL DEFAULT '0',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `add_content` tinyint(4) NOT NULL DEFAULT '0',
  `pub_content` tinyint(4) NOT NULL DEFAULT '0',
  `edit_content` tinyint(4) NOT NULL DEFAULT '0',
  `del_content` tinyint(4) NOT NULL DEFAULT '0',
  `app_content` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `nv4_vi_laws_admins` ADD UNIQUE KEY `userid` (`userid`,`catid`);
 
# thêm 2 trường sort vào bảng nv4_vi_laws_cat
``` 
ALTER TABLE `nv4_vi_laws_cat` ADD `sort` SMALLINT(5) NOT NULL DEFAULT '0' AFTER `weight`;
ALTER TABLE `nv4_vi_laws_cat` ADD `lev` SMALLINT(5) NOT NULL DEFAULT '0' AFTER `sort`; 
``` 