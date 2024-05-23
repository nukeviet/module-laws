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

use NukeViet\Module\laws\Shared\QuickViews;

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$lawalias = isset($array_op[1]) ? $array_op[1] : '';
$id = 0;

unset($m);
if (!preg_match('/^([a-z0-9\-]+)\-([0-9]+)$/i', $lawalias, $m) or isset($array_op[2])) {
    nv_redirect_location($base_url);
}
$id = intval($m[2]);
if ($id <= 0) {
    nv_redirect_location($base_url);
}
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE id=' . $id . ' AND status=1';
$row = $db->query($sql)->fetch();
if (empty($row)) {
    nv_redirect_location($base_url);
}

$page_title = $row['title'];
$key_words = $row['keywords'];
$description = $row['introtext'];

$base_url .= '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['detail'] . '/' . $row['alias'];
$page_url = $base_url;
$canonicalUrl = getCanonicalUrl($page_url);

$order = ($nv_laws_setting['typeview'] == 1 or $nv_laws_setting['typeview'] == 4) ? 'ASC' : 'DESC';
$order_param = ($nv_laws_setting['typeview'] == 0 or $nv_laws_setting['typeview'] == 1) ? (defined('ACTIVE_COMMENTS') ? 'start_comm_time' : 'publtime') : 'addtime';

$row['edit_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $row['id'];
$row['map_ids'] = $row['maps'] = $row['aid'] = [];
$row['maps_lang'] = [
    'all' => $nv_Lang->getModule('tab_maps_all'),
    'replacement' => $nv_Lang->getModule('replacement'),
    'unreplacement' => $nv_Lang->getModule('unreplacement'),
    'relatement' => $nv_Lang->getModule('relatement'),
];
$row['maps']['all'] = [];
if (isset($nv_laws_listcat[$row['cid']])) {
    $row['cat'] = $nv_laws_listcat[$row['cid']]['title'];
    $row['cat_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $nv_laws_listcat[$row['cid']]['alias'];
} else {
    $row['cat'] = '';
    $row['cat_url'] = '#';
}

if (isset($nv_laws_listsubject[$row['sid']])) {
    $row['subject'] = $nv_laws_listsubject[$row['sid']]['title'];
    $row['subject_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=subject/' . $nv_laws_listsubject[$row['sid']]['alias'];
} else {
    $row['subject'] = '';
    $row['subject_url'] = '';
}

$result = $db->query('SELECT area_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row_area WHERE row_id=' . $row['id']);
while (list ($area_id) = $result->fetch(3)) {
    $row['aid'][] = $area_id;
}

if (!nv_user_in_groups($row['groups_view'])) {
    nv_info_die($nv_Lang->getModule('info_no_allow'), $nv_Lang->getModule('info_no_allow'), $nv_Lang->getModule('info_no_allow_detail'));
}

if ($nv_Request->isset_request('download', 'get')) {
    $fileid = $nv_Request->get_int('id', 'get', 0);

    $row['files'] = explode(',', $row['files']);

    if (!isset($row['files'][$fileid])) {
        nv_redirect_location($base_url, true);
    }

    if (!file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['files'][$fileid])) {
        nv_redirect_location($base_url, true);
    }

    // Update download
    $lawsdownloaded = $nv_Request->get_string('lawsdownloaded', 'session', '');
    $lawsdownloaded = !empty($lawsdownloaded) ? unserialize($lawsdownloaded) : [];
    if (!in_array($row['id'], $lawsdownloaded)) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_row SET download_hits=download_hits+1 WHERE id=' . $row['id'];
        $db->query($sql);
        $lawsdownloaded[] = $row['id'];
        $lawsdownloaded = serialize($lawsdownloaded);
        $nv_Request->set_Session('lawsdownloaded', $lawsdownloaded);
    }

    $file_info = pathinfo(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['files'][$fileid]);
    $download = new NukeViet\Files\Download(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['files'][$fileid], $file_info['dirname'], $file_info['basename'], true);
    $download->download_file();
    exit();
}

if ($nv_Request->isset_request('pdf', 'get')) {
    $fileid = $nv_Request->get_int('id', 'get', 0);

    $row['files'] = explode(',', $row['files']);

    if (!isset($row['files'][$fileid])) {
        nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'), 404);
    }

    if (!file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['files'][$fileid])) {
        nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'), 404);
    }

    $file_url = $base_url . '&' . NV_OP_VARIABLE . '=' . $module_info['alias']['detail'] . '/' . $lawalias . '&download=1&id=' . $fileid;
    $contents = nv_theme_viewpdf($file_url);
    nv_htmlOutput($contents);
}

// Lấy văn bản thay thế cho văn bản đang xem
if (!empty($row['replacement'])) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE status=1 AND id IN(' . $row['replacement'] . ') ORDER BY ' . $order_param . ' ' . $order;
    $result = $db->query($sql);
    $row['maps']['replacement'] = raw_law_list_by_result($result);
    if (!empty($row['maps']['replacement'])) {
        $row['map_ids'] = array_merge($row['map_ids'], array_keys($row['maps']['replacement']));
    }
}

// Lấy văn bản bị văn bản đang xem thay thế
$sql = 'SELECT b.* FROM ' . NV_PREFIXLANG . '_' . $module_data . '_set_replace a
INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_row b ON a.oid=b.id WHERE a.nid=' . $row['id'] . ' AND b.status=1
ORDER BY b.' . $order_param . ' ' . $order;
$result = $db->query($sql);
$row['maps']['unreplacement'] = raw_law_list_by_result($result);
if (!empty($row['maps']['unreplacement'])) {
    $row['map_ids'] = array_merge($row['map_ids'], array_keys($row['maps']['unreplacement']));
}

// Lấy văn bản liên quan
if (!empty($row['relatement'])) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE status=1 AND id IN(' . $row['relatement'] . ') ORDER BY ' . $order_param . ' ' . $order;
    $result = $db->query($sql);
    $row['maps']['relatement'] = raw_law_list_by_result($result);
    if (!empty($row['maps']['relatement'])) {
        $row['map_ids'] = array_merge($row['map_ids'], array_keys($row['maps']['relatement']));
    }
}

$row['map_ids'] = array_unique(array_filter($row['map_ids']));
if (!empty($row['map_ids'])) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE status=1 AND id IN(' . implode(',', $row['map_ids']) . ') ORDER BY ' . $order_param . ' ' . $order;
    $result = $db->query($sql);
    $row['maps']['all'] = raw_law_list_by_result($result);
}

// Nguoi ky
if (!empty($row['sgid'])) {
    $sql = 'SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_signer WHERE id = ' . $row['sgid'];
    $result = $db->query($sql);
    list ($row['signer']) = $result->fetch(3);
    $row['signer_url'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=signer/' . $row['sgid'] . '/' . change_alias($row['signer']);
}

// Uy ban tham tra
if (!empty($row['eid'])) {
    $sql = 'SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_examine WHERE id = ' . $row['eid'];
    $result = $db->query($sql);
    list ($row['examine']) = $result->fetch(3);
}

// File download
$row['quick_view'] = 0;
$row['groups_download_array'] = explode(',', $row['groups_download']);

if (!empty($row['files'])) {
    $row['files'] = explode(',', $row['files']);
    $files = $row['files'];
    $row['files'] = [];

    foreach ($files as $id => $file) {
        $is_remote = (strpos($file, '//') !== false);
        $ext = $is_remote ? '' : nv_getextension($file);
        $file_title = !$is_remote ? basename($file) : $nv_Lang->getModule('click_to_download');
        $file_type = QuickViews::typeFile($ext);
        $url = !$is_remote ? urlRewriteWithDomain($base_url . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['detail'] . '/' . $lawalias . '&amp;download=1&amp;id=' . $id, NV_MY_DOMAIN) : $file;

        // Nếu pdf và ảnh thì xem nhanh nếu có set quyền download cũng được, các loại khác public download mới xem được
        $quick_view = ($file_type == 'image' or $file_type == 'pdf') ? true : (($file_type != '' and in_array(6, $row['groups_download_array'])) ? true : false);
        $quick_view && $quick_view = QuickViews::canPreview($ext);
        $quick_view = $quick_view ? in_array($quick_view, $nv_laws_setting['quickview']) : false;

        $row['files'][] = [
            'title' => $file_title,
            'key' => md5($id . $file_title),
            'ext' => nv_getextension($file_title),
            'titledown' => $nv_Lang->getModule('download') . ' ' . (count($files) > 1 ? $id + 1 : ''),
            'url' => $url,
            'url_encode' => urlencode(str_replace('&amp;', '&', $url)),
            'urlpdf' => $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['detail'] . '/' . $lawalias . '&amp;pdf=1&amp;id=' . $id,
            'file_type' => $file_type,
            'quick_view' => $quick_view,
        ];

        // Được phép tải về và file xem được trực tuyến
        if (nv_user_in_groups($row['groups_download']) and $quick_view) {
            $row['quick_view']++;
        }
    }
}

// Update view hit
$lawsviewed = $nv_Request->get_string('lawsviewed', 'session', '');
$lawsviewed = !empty($lawsviewed) ? unserialize($lawsviewed) : [];
if (!in_array($row['id'], $lawsviewed)) {
    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_row SET view_hits=view_hits+1 WHERE id=' . $row['id'];
    $db->query($sql);
    $lawsviewed[] = $row['id'];
    $lawsviewed = serialize($lawsviewed);
    $nv_Request->set_Session('lawsviewed', $lawsviewed);
}

$nv_laws_setting['detail_other'] = unserialize($nv_laws_setting['detail_other']);
$other_cat = [];
$other_area = [];
$other_subject = [];
$other_signer = [];

if ($nv_laws_setting['detail_other']) {
    if (in_array('cat', $nv_laws_setting['detail_other'])) {
        $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE cid=' . $row['cid'] . ' AND id!=' . $row['id'] . ' ORDER BY addtime ' . $order . ' LIMIT ' . $nv_laws_setting['other_numlinks']);
        while ($data = $result->fetch()) {
            $data['url'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=detail/' . $data['alias'];
            $other_cat[$data['id']] = $data;
        }
    }

    if (in_array('area', $nv_laws_setting['detail_other'])) {
        foreach ($row['aid'] as $key => $aid) {
            $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_row_area t2 ON t1.id=t2.row_id WHERE t2.area_id = ' . $aid . ' AND t1.id!=' . $row['id'] . ' ORDER BY addtime ' . $order . ' LIMIT ' . $nv_laws_setting['other_numlinks']);
            while ($data = $result->fetch()) {
                $data['url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=detail/' . $data['alias'];
                $other_area[$data['area_id']][$data['id']] = $data;
            }
        }
    }

    if (in_array('subject', $nv_laws_setting['detail_other'])) {
        $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sid=' . $row['sid'] . ' AND id!=' . $row['id'] . ' ORDER BY addtime ' . $order . ' LIMIT ' . $nv_laws_setting['other_numlinks']);
        while ($data = $result->fetch()) {
            $data['url'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=detail/' . $data['alias'];
            $other_subject[$data['id']] = $data;
        }
    }

    if (in_array('singer', $nv_laws_setting['detail_other'])) {
        $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_row WHERE sgid=' . $row['sgid'] . ' AND id!=' . $row['id'] . ' ORDER BY addtime ' . $order . ' LIMIT ' . $nv_laws_setting['other_numlinks']);
        while ($data = $result->fetch()) {
            $data['url'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=detail/' . $data['alias'];
            $other_signer[$data['id']] = $data;
        }
    }
}

// Lấy ý kiến góp ý (bình luận)
if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm'])) {
    define('NV_COMM_ID', $row['id']); // ID văn bản
    define('NV_COMM_AREA', $module_info['funcs'][$op]['func_id']); // Phạm vi comment
    // Check allow comemnt
    if ((empty($row['start_comm_time']) or $row['start_comm_time'] <= NV_CURRENTTIME) and (empty($row['end_comm_time']) or $row['end_comm_time'] > NV_CURRENTTIME)) {
        // Nếu trong thời gian lấy ý kiến thì xác định quyền cho ý kiến dựa theo cấu hình
        $allowed = $module_config[$module_name]['allowed_comm'];
        if ($allowed == '-1') {
            // Nếu cấu hình giá trị là tùy vào bài viết thì để mặc định là tất cả mọi người được comment
            $allowed = 6;
        }
    } else {
        // Ngoài thời gian lấy ý kiến thì điều hành chung trở lên được bình luận
        $allowed = 2;
    }

    require_once NV_ROOTDIR . '/modules/comment/comment.php';
    $area = (defined('NV_COMM_AREA')) ? NV_COMM_AREA : 0;
    $checkss = md5($module_name . '-' . $area . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX);

    $content_comment = nv_comment_module($module_name, $checkss, $area, NV_COMM_ID, $allowed, 1);
} else {
    $content_comment = '';
}

/*
 * Định các tabs hiển thị
 */
$tab_show = $nv_Request->get_title('tab', 'get', '');
if ($tab_show and !in_array($tab_show, ['basic', 'body', 'maps', 'files'])) {
    $tab_show = '';
}
$row['tabs'] = [];
$row['tab_show'] = $tab_show ? $tab_show : 'basic';
// Tab cơ bản
$row['tabs']['doc-basic'] = [
    'active' => (empty($tab_show) or $tab_show == 'basic'),
    'title' => $nv_Lang->getModule('tab_basic'),
    'link' => $page_url . '&amp;tab=basic'
];
// Tab nội dung
if (!empty($row['bodytext']) or $row['quick_view']) {
    $row['tabs']['doc-body'] = [
        'active' => (empty($tab_show) or $tab_show == 'body'),
        'title' => $nv_Lang->getModule('bodytext'),
        'link' => $page_url . '&amp;tab=body'
    ];
    // Active tab nội dung thì không active mặc định tab basic nữa
    if (empty($tab_show)) {
        $row['tabs']['doc-basic']['active'] = 0;
        $row['tab_show'] = 'body';
    }
}
// Tab liên quan
if (!empty($row['maps']['all'])) {
    $row['tabs']['doc-maps'] = [
        'active' => ($tab_show == 'maps'),
        'title' => $nv_Lang->getModule('tab_maps'),
        'link' => $page_url . '&amp;tab=maps'
    ];
}

// Tab tải về
if (!empty($row['files'])) {
    $row['tabs']['doc-files'] = [
        'active' => ($tab_show == 'files'),
        'title' => $nv_Lang->getModule('tab_download'),
        'link' => $page_url . '&amp;tab=files'
    ];
}

/*
 * Định các field hiển thị trong bảng thuộc tính
 */
$row['properties'] = [];

// Cơ quan ban hành
if (empty($nv_laws_setting['detail_hide_empty_field']) or isset($nv_laws_listsubject[$row['sid']])) {
    $row['properties']['subject'] = [
        'label' => $nv_Lang->getModule('subject'),
        'link' => !empty($nv_laws_setting['detail_show_link_subject']) ? (NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=subject/' . $nv_laws_listsubject[$row['sid']]['alias']) : '',
        'value' => $nv_laws_listsubject[$row['sid']]['title']
    ];
}
// Số hiệu văn bản
$row['properties']['code'] = [
    'label' => $nv_Lang->getModule('code'),
    'value' => $row['code']
];
// Loại văn bản
if (empty($nv_laws_setting['detail_hide_empty_field']) or isset($nv_laws_listcat[$row['cid']])) {
    $row['properties']['cat'] = [
        'label' => $nv_Lang->getModule('cat'),
        'link' => !empty($nv_laws_setting['detail_show_link_cat']) ? (NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $nv_laws_listcat[$row['cid']]['alias']) : '',
        'value' => $nv_laws_listcat[$row['cid']]['title']
    ];
}
// Người kí
if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($row['signer'])) {
    $row['properties']['signer'] = [
        'label' => $nv_Lang->getModule('signer'),
        'link' => !empty($nv_laws_setting['detail_show_link_signer']) ? $row['signer_url'] : '',
        'value' => $row['signer']
    ];
}
// Lĩnh vực
if (!empty($row['aid'])) {
    $aid = [];
    foreach ($row['aid'] as $_aid) {
        if (!isset($nv_laws_listarea[$_aid])) {
            continue;
        }
        $aid[$_aid] = [
            'value' => $nv_laws_listarea[$_aid]['title'],
            'link' => !empty($nv_laws_setting['detail_show_link_area']) ? (NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=area/' . $nv_laws_listarea[$_aid]['alias']) : '',
        ];
    }
    if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($aid)) {
        $row['properties']['area'] = [
            'label' => $nv_Lang->getModule('area'),
            'value' => $aid
        ];
    }
}
if (defined('ACTIVE_COMMENTS')) {
    // Thuộc tính trong trường hợp lấy ý kiến dự thảo: Ngày bắt đầu, kết thúc lấy ý kiến và cơ quan thẩm tra
    $row['properties']['start_comm_time'] = [
        'label' => $nv_Lang->getModule('start_comm_time_title'),
        'value' => $nv_Lang->getModule('unlimit'),
        'time' => $row['start_comm_time']
    ];
    $row['properties']['end_comm_time'] = [
        'label' => $nv_Lang->getModule('end_comm_time_title'),
        'value' => $nv_Lang->getModule('unlimit'),
        'time' => $row['end_comm_time']
    ];
    $row['properties']['approval'] = [
        'label' => $nv_Lang->getModule('approval'),
        'value' => $nv_Lang->getModule('e' . $row['approval'])
    ];
    // Cơ quan thẩm tra
    if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($row['examine'])) {
        $row['properties']['examine'] = [
            'label' => $nv_Lang->getModule('examine'),
            'value' => $row['examine']
        ];
    }
} else {
    // Thuộc tính trong trường hợp văn bản thường
    if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($row['effective_status'])) {
        $row['properties']['effective_status'] = [
            'label' => $nv_Lang->getModule('effective_status'),
            'value' => $nv_Lang->getModule('effective_status' . $row['effective_status'])
        ];
    }
    // Ngày ban hành
    $row['properties']['publtime'] = [
        'label' => $nv_Lang->getModule('publtime'),
        'time' => $row['publtime']
    ];
    // Ngày hiệu lực
    if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($row['startvalid'])) {
        $row['properties']['startvalid'] = [
            'label' => $nv_Lang->getModule('startvalid'),
            'time' => $row['startvalid']
        ];
    }
    // Ngày hết hiệu lực
    if (empty($nv_laws_setting['detail_hide_empty_field']) or !empty($row['exptime'])) {
        $row['properties']['exptime'] = [
            'label' => $nv_Lang->getModule('exptime'),
            'time' => $row['exptime']
        ];
    }
}

// Xác định mục lục của văn bản theo quy luật: h2 > h3.
$row['navigation'] = [];
if (!empty($row['bodytext'])) {
    unset($matches);
    preg_match_all('/\<[\s]*(h2|h3)([^\>]*)\>(.*?)\<[\s]*\/[\s]*(h2|h3)[\s]*\>/is', $row['bodytext'], $matches, PREG_SET_ORDER);

    $nav1 = $nav2 = 0;
    $idname = 'art-menu-';

    foreach ($matches as $match) {
        $text = trim(preg_replace('/\s[\s]+/is', ' ', strip_tags(nv_br2nl($match[3], ' '))));
        $tag = strtolower($match[1]);
        if (empty($text)) {
            continue;
        }

        if ($tag == 'h2') {
            $nav1++;
            $nav2++;
            $attrid = $idname . $nav2;

            $html = '<' . $tag . $match[2] . ' data-id="' . $attrid . '">' . $match[3] . '</' . $tag . '>';
            $row['navigation'][$nav1]['item'] = [$text, $attrid];
            $row['bodytext'] = str_replace($match[0], $html, $row['bodytext']);
        } elseif ($nav1) {
            $nav2++;
            $attrid = $idname . $nav2;

            $html = '<' . $tag . $match[2] . ' data-id="' . $attrid . '">' . $match[3] . '</' . $tag . '>';
            !isset($row['navigation'][$nav1]['subitems']) && $row['navigation'][$nav1]['subitems'] = [];
            $row['navigation'][$nav1]['subitems'][] = [$text, $attrid];
            $row['bodytext'] = str_replace($match[0], $html, $row['bodytext']);
        }
    }
}

$contents = nv_theme_laws_detail($row, $other_cat, $other_area, $other_subject, $other_signer, $content_comment);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
