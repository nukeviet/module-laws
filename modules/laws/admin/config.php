<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['config'];

$array_config = array();

if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
    $array_config['nummain'] = $nv_Request->get_int( 'nummain', 'post', 0 );
    $array_config['numsub'] = $nv_Request->get_int( 'numsub', 'post', 0 );
    $array_config['typeview'] = $nv_Request->get_int( 'typeview', 'post', 0 );

    foreach ( $array_config as $config_name => $config_value )
    {
		$query = "REPLACE INTO `" . NV_PREFIXLANG . "_" . $module_data . "_config` VALUES (" . $db->quote( $config_name ) . "," . $db->quote( $config_value ) . ")";
		$db->query( $query );
    }

    nv_del_moduleCache( $module_name );

    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
    die();
}

$array_config['nummain'] = 50;
$array_config['numsub'] = 50;
$array_config['typeview'] = 0;

$sql = "SELECT `config_name`, `config_value` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config`";
$result = $db->query( $sql );
while ( list( $c_config_name, $c_config_value ) = $result->fetch( 3 ) )
{
    $array_config[$c_config_name] = $c_config_value;
}

$typeview = array();
for( $i = 0; $i <= 1; $i ++ )
{
	$typeview[] = array(
		"id" => $i,  //
		"title" => $lang_module['type_view_' . $i],  //
        "selected" => ( $i == $array_config['typeview'] ) ? " selected=\"selected\"" : "" //
	);
}

$xtpl = new XTemplate( "config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $array_config );

foreach ( $typeview as $type )
{
    $xtpl->assign( 'typeview', $type );
    $xtpl->parse( 'main.typeview' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';

?>