<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['config'];

$array_config = [];
$array_config_comm = $module_config[$module_name];

if ($nv_Request->isset_request('btnsubmit', 'post')) {
    $array_config['nummain'] = $nv_Request->get_int('nummain', 'post', 0);
    $array_config['numsub'] = $nv_Request->get_int('numsub', 'post', 0);
    $array_config['typeview'] = $nv_Request->get_int('typeview', 'post', 0);
    $array_config['down_in_home'] = $nv_Request->get_int('down_in_home', 'post', 0);
    $array_config['other_numlinks'] = $nv_Request->get_int('other_numlinks', 'post', 5);
    $array_config['detail_other'] = $nv_Request->get_array('detail_other', 'post', []);
    $array_config['detail_other'] = serialize($array_config['detail_other']);
    $array_config['detail_hide_empty_field'] = $nv_Request->get_int('detail_hide_empty_field', 'post', 0);
    $array_config['detail_show_link_cat'] = $nv_Request->get_int('detail_show_link_cat', 'post', 0);
    $array_config['detail_show_link_area'] = $nv_Request->get_int('detail_show_link_area', 'post', 0);
    $array_config['detail_show_link_subject'] = $nv_Request->get_int('detail_show_link_subject', 'post', 0);
    $array_config['detail_show_link_signer'] = $nv_Request->get_int('detail_show_link_signer', 'post', 0);
    $array_config['detail_pdf_quick_view'] = $nv_Request->get_int('detail_pdf_quick_view', 'post', 0);

    $array_config['title_show_type'] = $nv_Request->get_int('title_show_type', 'post', 0);
    if ($array_config['title_show_type'] < 0 or $array_config['title_show_type'] > 2) {
        $array_config['title_show_type'] = 0;
    }

    $array_config_comm['activecomm'] = $nv_Request->get_int('activecomm', 'post', 0);

    $sth = $db->prepare("UPDATE " . NV_PREFIXLANG . '_' . $module_data . "_config SET config_value = :config_value WHERE config_name = :config_name");
    foreach ($array_config as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR, 30);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }
    $nv_Cache->delMod($module_name);
    //Lưu cấu hình cho phép lấy ý kiến góp ý tại bảng nv4_config
    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($array_config_comm as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $nv_Cache->delMod('settings');

    nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op);
}

$array_config['nummain'] = 50;
$array_config['numsub'] = 50;
$array_config['typeview'] = 0;
$array_config['down_in_home'] = 1;
$array_config['other_numlinks'] = 5;
$array_config['detail_other'] = 'a:0:{}';
$array_config['detail_hide_empty_field'] = 1;
$array_config['detail_show_link_cat'] = 1;
$array_config['detail_show_link_area'] = 1;
$array_config['detail_show_link_subject'] = 1;
$array_config['detail_show_link_signer'] = 1;
$array_config['detail_pdf_quick_view'] = 0;
$array_config['title_show_type'] = 0;

$sql = "SELECT config_name, config_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config";
$result = $db->query($sql);
while (list ($c_config_name, $c_config_value) = $result->fetch(3)) {
    $array_config[$c_config_name] = $c_config_value;
}
$array_config['activecomm'] = $module_config[$module_name]['activecomm'];
$typeview = [];
for ($i = 0; $i <= 4; $i++) {
    $typeview[] = [
        "id" => $i,
        "title" => $lang_module['type_view_' . $i],
        "selected" => ($i == $array_config['typeview']) ? " selected=\"selected\"" : ""
    ];
}

$array_config['down_in_home'] = $array_config['down_in_home'] ? 'checked="checked"' : '';
$array_config['detail_hide_empty_field'] = $array_config['detail_hide_empty_field'] ? 'checked="checked"' : '';
$array_config['detail_show_link_cat'] = $array_config['detail_show_link_cat'] ? 'checked="checked"' : '';
$array_config['detail_show_link_area'] = $array_config['detail_show_link_area'] ? 'checked="checked"' : '';
$array_config['detail_show_link_subject'] = $array_config['detail_show_link_subject'] ? 'checked="checked"' : '';
$array_config['detail_show_link_signer'] = $array_config['detail_show_link_signer'] ? 'checked="checked"' : '';
$array_config['detail_pdf_quick_view'] = $array_config['detail_pdf_quick_view'] ? 'checked="checked"' : '';
$array_config['activecomm'] = $array_config['activecomm'] ? 'checked="checked"' : '';

$xtpl = new XTemplate("config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('DATA', $array_config);

foreach ($typeview as $type) {
    $xtpl->assign('typeview', $type);
    $xtpl->parse('main.typeview');
}

$array_other = [
    'cat' => $lang_module['config_detail_other_cat'],
    'area' => $lang_module['config_detail_other_area'],
    'subject' => $lang_module['config_detail_other_subject'],
    'singer' => $lang_module['config_detail_other_signer']
];
$array_config['detail_other'] = !empty($array_config['detail_other']) ? unserialize($array_config['detail_other']) : [];

foreach ($array_other as $key => $value) {
    $ck = in_array($key, $array_config['detail_other']) ? 'checked="checked"' : '';
    $xtpl->assign('OTHER', [
        'key' => $key,
        'value' => $value,
        'checked' => $ck
    ]);
    $xtpl->parse('main.detail_other');
}

for ($i = 0; $i <= 2; $i++) {
    $xtpl->assign('TITLE_SHOW_TYPE', [
        'key' => $i,
        'title' => $lang_module['config_tshow' . $i],
        'selected' => $array_config['title_show_type'] == $i ? ' selected' : ''
    ]);
    $xtpl->parse('main.title_show_type');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
