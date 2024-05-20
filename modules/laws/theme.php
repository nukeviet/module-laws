<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LAWS')) {
    die('Stop!!!');
}

/**
 * Quy chuẩn hiển thị văn bản dạng danh sách
 *
 * @param array $array_data
 * @param string $generate_page
 * @param boolean $show_header
 * @param boolean $show_stt
 * @return string
 */
function nv_theme_laws_list($array_data, $generate_page = '', $show_header = true, $show_stt = true)
{
    global $module_info, $nv_laws_setting, $module_name, $module_config, $nv_Lang;

    $xtpl = new XTemplate('list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

    foreach ($array_data as $row) {
        $row['url_subject'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=subject/' . $row['alias'];
        $row['publtime'] = $row['publtime'] ? nv_date('d/m/Y', $row['publtime']) : 'N/A';
        $row['exptime'] = $row['exptime'] ? nv_date('d/m/Y', $row['exptime']) : 'N/A';
        $row['number_comm'] = $row['number_comm'] ? sprintf($nv_Lang->getModule('number_comm'), number_format($row['number_comm'], 0, ',', '.')) : '';

        $xtpl->assign('ROW', $row);

        if (empty($nv_laws_setting['title_show_type'])) {
            // Hiển thị trích yếu
            $xtpl->assign('LAW_TITLE', $row['introtext']);
        } elseif ($nv_laws_setting['title_show_type'] == 1) {
            // Hiển thị tiêu đề
            $xtpl->assign('LAW_TITLE', $row['title']);
        } else {
            // Hiển thị tiêu đề + trích yếu
            $xtpl->assign('LAW_TITLE', $row['title']);
            $xtpl->parse('main.loop.introtext');
        }

        // Tải file trực tiếp
        if ($nv_laws_setting['down_in_home']) {
            if (nv_user_in_groups($row['groups_download'])) {
                if (!empty($row['files'])) {
                    foreach ($row['files'] as $file) {
                        $xtpl->assign('FILE', $file);
                        $xtpl->parse('main.loop.down_in_home.files.loopfile');
                    }
                    $xtpl->parse('main.loop.down_in_home.files');
                }
            }
            $xtpl->parse('main.loop.down_in_home');
        }

        /*
         * Công cụ của admin (chỉ điều hành chung và admin tối cao)
         * Quản trị module bỏ qua vì còn phân quyền theo cơ quan ban hành
         */
        if (defined('NV_IS_SPADMIN')) {
            $xtpl->assign('LINK_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
            $xtpl->parse('main.loop.admin_link');
        }

        // Lấy ý kiến dự thảo
        if ($module_config[$module_name]['activecomm']) {
            $comment_time = [];
            if (!empty($row['start_comm_time'])) {
                $comment_time[] = sprintf($nv_Lang->getModule('start_comm_time'), nv_date('d/m/Y', $row['start_comm_time']));
            }
            if (!empty($row['end_comm_time'])) {
                $comment_time[] = sprintf($nv_Lang->getModule('end_comm_time'), nv_date('d/m/Y', $row['end_comm_time']));
            }
            if (!empty($comment_time)) {
                $xtpl->assign('COMMENT_TIME', implode(' - ', $comment_time));
                $xtpl->parse('main.loop.comment_time');
            }

            if ($row['number_comm']) {
                $xtpl->parse('main.loop.shownumbers');
            }

            if ($row['allow_comm']) {
                $xtpl->parse('main.loop.send_comm');
            } else {
                $xtpl->parse('main.loop.comm_close');
            }
        } else {
            $xtpl->parse('main.loop.publtime');
        }

        // Hiển thị cột số thứ tự
        if ($show_stt) {
            $xtpl->parse('main.loop.stt');
        }

        $xtpl->parse('main.loop');
    }

    // Hiển thị tiêu đề
    if ($show_header) {
        // Tiêu đề khi lấy ý kiến dự thảo
        if ($module_config[$module_name]['activecomm']) {
            $xtpl->parse('main.header.send_comm_title');
        } else {
            $xtpl->parse('main.header.publtime_title');
        }

        // Tiêu đề khi tải file
        if ($nv_laws_setting['down_in_home']) {
            $xtpl->parse('main.header.down_in_home');
        }

        // Hiển thị cột số thứ tự
        if ($show_stt) {
            $xtpl->parse('main.header.stt');
        }

        $xtpl->parse('main.header');
    }

    // Phân trang
    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang chủ của module ở dạng xem theo danh sách
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @return
 */
function nv_theme_laws_main($array_data, $generate_page)
{
    global $module_info, $nv_Lang;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang chủ của module ở dạng xem theo cơ quan ban hành
 *
 * @param mixed $mod
 * @param mixed $array_data
 * @return
 */
function nv_theme_laws_maincat($mod, $array_data)
{
    global $global_config, $module_name, $module_config, $module_info, $op, $nv_laws_setting, $nv_Lang;

    $xtpl = new XTemplate('main_' . $mod . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    foreach ($array_data as $data) {
        $data['url_subject'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=subject/' . $data['alias'];
        $data['numcount'] = sprintf($nv_Lang->getModule('s_result_num'), $data['numcount']);

        $xtpl->assign('DATA', $data);

        if (!empty($data['rows'])) {
            $xtpl->assign('HTML', nv_theme_laws_list($data['rows'], '', false, false));
            $xtpl->parse('main.loop.rows');
        }

        $xtpl->parse('main.loop');
    }

    if (!empty($module_config[$module_name]['activecomm'])) {
        $xtpl->parse('main.send_comm_title');
    } else {
        $xtpl->parse('main.publtime_title');
    }

    if ($nv_laws_setting['down_in_home']) {
        $xtpl->parse('main.down_in_home');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Xem chi tiết văn bản
 *
 * @param array $array_data
 * @param array $other_cat
 * @param array $other_area
 * @param array $other_subject
 * @param array $other_signer
 * @param string $content_comment
 * @return
 */
function nv_theme_laws_detail($array_data, $other_cat, $other_area, $other_subject, $other_signer, $content_comment)
{
    global $global_config, $module_name, $module_config, $module_info, $op, $nv_laws_listcat, $nv_laws_listarea, $nv_laws_listsubject, $client_info, $nv_laws_setting, $nv_Lang;

    $xtpl = new XTemplate($module_info['funcs'][$op]['func_name'] . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    $enable_responsive = (!empty($global_config['current_theme_type']) and $global_config['current_theme_type'] == 'd') ? false : true;
    $xtpl->assign('RESPONSIVE', $enable_responsive ? ' enable-responsive' : '');

    foreach ($array_data['tabs'] as $tab_id => $tab) {
        $xtpl->assign('ID', $tab_id);
        $xtpl->assign('TITLE', $tab['title']);
        $xtpl->assign('LINK', $tab['link']);

        if (!empty($tab['active'])) {
            $xtpl->parse('main.tab.active');
        }

        $xtpl->parse('main.tab');
    }

    $xtpl->assign('ACTIVE_BASIC', $array_data['tab_show'] == 'basic' ? ' active' : '');
    $xtpl->assign('ACTIVE_BODY', $array_data['tab_show'] == 'body' ? ' active' : '');
    $xtpl->assign('ACTIVE_MAPS', $array_data['tab_show'] == 'maps' ? ' active' : '');
    $xtpl->assign('ACTIVE_FILES', $array_data['tab_show'] == 'files' ? ' active' : '');
    $xtpl->assign('DATA', $array_data);

    // Xử lý bảng thuộc tính
    if (!empty($array_data['properties'])) {
        $properties = array_chunk($array_data['properties'], 2, true);

        foreach ($properties as $lines) {
            $num = sizeof($lines);

            foreach ($lines as $col) {
                if ($num < 2) {
                    $xtpl->parse('main.properties.tr.td.colspan');
                }
                !empty($col['time']) && ($col['value'] = nv_date('d/m/Y', $col['time']));
                $xtpl->assign('COL', $col);

                if (!is_array($col['value'])) {
                    // Dạng single value
                    if (empty($col['link'])) {
                        $xtpl->parse('main.properties.tr.td.text');
                    } else {
                        $xtpl->parse('main.properties.tr.td.link');
                    }
                } else {
                    // Dạng multi value
                    $stt = 0;
                    foreach ($col['value'] as $value) {
                        $xtpl->assign('COL_VALUE', $value);
                        $stt++;
                        if ($stt > 1) {
                            $xtpl->parse('main.properties.tr.td.value.separator');
                        }
                        if (empty($value['link'])) {
                            $xtpl->parse('main.properties.tr.td.value.text');
                        } else {
                            $xtpl->parse('main.properties.tr.td.value.link');
                        }
                        $xtpl->parse('main.properties.tr.td.value');
                    }
                }

                $xtpl->parse('main.properties.tr.td');
            }

            $xtpl->parse('main.properties.tr');
        }

        $xtpl->parse('main.properties');
    }

    /*
     * Sửa và xóa văn bản dành cho admin tối cao và điều hành chung
     * Quản trị module cần thao tác trong admin vì còn phân quyền
     */
    if (defined('NV_IS_SPADMIN')) {
        $xtpl->assign('LINK_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        $xtpl->parse('main.admin_link');
    }

    $icon_sets = [
        '' => 'fa fa-file-text-o',
        'pdf' => 'fa fa-file-pdf-o',
        'word' => 'fa fa-file-word-o',
        'excel' => 'fa fa-file-excel-o',
        'powerpoint' => 'fa fa-file-powerpoint-o',
        'image' => 'fa fa-file-image-o',
    ];

    // Tab nội dung
    if (isset($array_data['tabs']['doc-body'])) {
        if (!empty($array_data['bodytext'])) {
            // Nội dung văn bản được soạn thảo
            $xtpl->parse('main.docbody.bodytext');

            if (!empty($array_data['navigation'])) {
                foreach ($array_data['navigation'] as $item) {
                    $xtpl->assign('NAVIGATION', $item['item']);

                    if (!empty($item['subitems'])) {
                        foreach ($item['subitems'] as $subitem) {
                            $xtpl->assign('SUBNAVIGATION', $subitem);
                            $xtpl->parse('main.navigation.navigation_item.sub_navigation.sub_navigation_item');
                        }
                        $xtpl->parse('main.navigation.navigation_item.sub_navigation');
                    }

                    $xtpl->parse('main.navigation.navigation_item');
                }

                $xtpl->parse('main.navigation');
            }
        } else {
            // Xem nội dung từ các file đính kèm
            foreach ($array_data['files'] as $file) {
                if (!$file['quick_view']) {
                    continue;
                }

                $file['icon'] = $icon_sets[$file['file_type']];

                $xtpl->assign('FILE', $file);

                if ($file['file_type'] == 'image') {
                    // Ảnh
                    $xtpl->parse('main.docbody.fileview.img');
                } elseif ($file['file_type'] == 'pdf') {
                    // PDF
                    $xtpl->parse('main.docbody.fileview.pdf');
                } else {
                    // MS
                    $xtpl->parse('main.docbody.fileview.iframe');
                }

                $xtpl->parse('main.docbody.fileview');
            }
        }
        $xtpl->parse('main.docbody');
    }

    // Tải tập tin
    if (isset($array_data['tabs']['doc-files'])) {
        if (!nv_user_in_groups($array_data['groups_download'])) {
            $xtpl->parse('main.files.noright');
        } else {
            foreach ($array_data['files'] as $file) {
                $file['icon'] = $icon_sets[$file['file_type']];
                $xtpl->assign('FILE', $file);

                if ($file['quick_view']) {
                    $xtpl->parse('main.files.content.loop.show_quick_view');
                    $xtpl->parse('main.files.content.loop.content_quick_view');
                }

                $xtpl->parse('main.files.content.loop');
            }

            $xtpl->parse('main.files.content');
        }
        $xtpl->parse('main.files');
    }

    // Tab liên quan
    if (isset($array_data['tabs']['doc-maps'])) {
        $stt = 0;
        foreach ($array_data['maps'] as $map_id => $map_rows) {
            if (empty($map_rows)) {
                continue;
            }
            $stt++;
            $xtpl->assign('NAV_ACTIVE', $stt == 1 ? ' active' : '');
            $xtpl->assign('NAV_ID', $map_id);
            $xtpl->assign('NAV_NAME', $array_data['maps_lang'][$map_id]);
            $xtpl->assign('NAV_NUM', number_format(sizeof($map_rows), 0, ',', '.'));
            $xtpl->parse('main.maps.nav');

            $xtpl->assign('HTML', nv_theme_laws_detail_map($map_rows));
            $xtpl->parse('main.maps.map');
        }

        $xtpl->parse('main.maps');
    }

    if (!empty($array_data['bodytext'])) {
        $xtpl->assign('OTHER_HEADING', 'div');
        $xtpl->assign('OTHER_CLASS', ' h2');
    } else {
        $xtpl->assign('OTHER_HEADING', 'h2');
        $xtpl->assign('OTHER_CLASS', '');
    }

    if (!empty($other_cat)) {
        $xtpl->assign('OTHER_CAT', nv_theme_laws_list_other($other_cat));
        $xtpl->parse('main.other_cat');
    }

    if (!empty($other_area)) {
        foreach ($other_area as $key => $data) {
            if (isset($nv_laws_listarea[$key])) {
                $data_area['area'] = $nv_laws_listarea[$key]['title'];
                $data_area['area_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=area/' . $nv_laws_listarea[$key]['alias'];
            } else {
                $data_area['area'] = '';
                $data_area['area_url'] = '#';
            }
            $xtpl->assign('AREA_TITLE', $data_area);
            $xtpl->assign('OTHER_AREA', nv_theme_laws_list_other($data));
            $xtpl->parse('main.other_area');
        }
    }

    if (!empty($other_subject)) {
        $xtpl->assign('OTHER_SUBJECT', nv_theme_laws_list_other($other_subject));
        $xtpl->parse('main.other_subject');
    }

    if (!empty($other_signer)) {
        $xtpl->assign('OTHER_SIGNER', nv_theme_laws_list_other($other_signer));
        $xtpl->parse('main.other_signer');
    }

    if (!empty($content_comment)) {
        $xtpl->assign('CONTENT_COMMENT', $content_comment);
        $xtpl->parse('main.comment');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Danh sách các văn bản liên quan, lược đồ khi xem chi tiết văn bản
 *
 * @param array $array
 * @return string
 */
function nv_theme_laws_detail_map(array $array)
{
    global $module_info;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    foreach ($array as $row) {
        $row['stt'] = str_pad(number_format($row['stt'], 0, ',', '.'), 2, '0', STR_PAD_LEFT);
        $row['publtime'] = $row['publtime'] ? nv_date('d/m/Y', $row['publtime']) : '';

        $xtpl->assign('ROW', $row);

        if (!empty($row['publtime'])) {
            $xtpl->parse('mapitems.loop.publtime');
        }
        $xtpl->parse('mapitems.loop');
    }

    $xtpl->parse('mapitems');
    return $xtpl->text('mapitems');
}

/**
 * Trang tìm kiếm văn bản
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @param mixed $all_page
 * @return
 */
function nv_theme_laws_search($array_data, $generate_page, $all_page)
{
    global $global_config, $module_name, $module_info, $op, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('NUMRESULT', sprintf($nv_Lang->getModule('s_result_num'), $all_page));

    if (empty($array_data)) {
        $xtpl->parse('empty');
        return $xtpl->text('empty');
    }

    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang xem văn bản theo lĩnh vực
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @param mixed $cat
 * @return
 */
function nv_theme_laws_area($array_data, $generate_page, $cat)
{
    global $global_config, $module_name, $module_info, $op, $nv_laws_setting, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAT', $cat);
    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang xem văn bản theo thể loại
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @param mixed $cat
 * @return
 */
function nv_theme_laws_cat($array_data, $generate_page, $cat)
{
    global $global_config, $module_name, $module_info, $op, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAT', $cat);
    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang xem văn bản theo cơ quan ban hành
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @param mixed $cat
 * @return
 */
function nv_theme_laws_subject($array_data, $generate_page, $cat)
{
    global $global_config, $module_name, $nv_laws_setting, $module_info, $op, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAT', $cat);
    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Trang xem văn bản theo người ký
 *
 * @param mixed $array_data
 * @param mixed $generate_page
 * @param mixed $cat
 * @return
 */
function nv_theme_laws_signer($array_data, $generate_page, $cat)
{
    global $global_config, $module_name, $module_info, $op, $nv_laws_setting, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAT', $cat);
    $xtpl->assign('HTML', nv_theme_laws_list($array_data, $generate_page));

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Danh sách các văn bản khác tại phần xem chi tiết văn bản
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_laws_list_other($array_data)
{
    global $global_config, $module_name, $module_info, $op, $nv_laws_setting, $module_config, $site_mods, $nv_Lang;

    $xtpl = new XTemplate('list_other.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    foreach ($array_data as $row) {
        $row['publtime'] = $row['publtime'] ? nv_date('d/m/Y', $row['publtime']) : 'N/A';
        $row['exptime'] = $row['exptime'] ? nv_date('d/m/Y', $row['exptime']) : 'N/A';

        $row['comm_time'] = [];
        if (!empty($row['start_comm_time'])) {
            $row['comm_time'][] = sprintf($nv_Lang->getModule('start_comm_time'), nv_date('d/m/Y', $row['start_comm_time']));
        }
        if (!empty($row['end_comm_time'])) {
            $row['comm_time'][] = sprintf($nv_Lang->getModule('end_comm_time'), nv_date('d/m/Y', $row['end_comm_time']));
        }
        $row['comm_time'] = implode(' - ', $row['comm_time']);

        $xtpl->assign('ROW', $row);

        if (empty($nv_laws_setting['title_show_type'])) {
            // Hiển thị trích yếu
            $xtpl->assign('LAW_TITLE', $row['introtext']);
        } elseif ($nv_laws_setting['title_show_type'] == 1) {
            // Hiển thị tiêu đề
            $xtpl->assign('LAW_TITLE', $row['title']);
        } else {
            // Hiển thị tiêu đề + trích yếu
            $xtpl->assign('LAW_TITLE', $row['title']);
            $xtpl->parse('main.loop.introtext');
        }

        if (isset($site_mods['comment']) and !empty($module_config[$module_name]['activecomm'])) {
            $xtpl->parse('main.loop.comm_time');
        } else {
            $xtpl->parse('main.loop.publtime');
        }

        $xtpl->parse('main.loop');
    }

    if (isset($site_mods['comment']) and !empty($module_config[$module_name]['activecomm'])) {
        $xtpl->parse('main.comm_time');
    } else {
        $xtpl->parse('main.publtime_title');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Xem trước văn bản khi file đính kèm là PDF
 *
 * @param mixed $file_url
 * @return
 */
function nv_theme_viewpdf($file_url)
{
    global $nv_Lang;
    $xtpl = new XTemplate('viewer.tpl', NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/js/pdf.js');
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('PDF_JS_DIR', NV_STATIC_URL . NV_ASSETS_DIR . '/js/pdf.js/');
    $xtpl->assign('PDF_URL', nv_url_rewrite(str_replace('&amp;', '&', $file_url), true));
    $xtpl->parse('main');
    return $xtpl->text('main');
}
