<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */


if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '27/07/2011, 14:55';
$lang_translator['copyright'] = '@Copyright (C) 2011 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['info'] = 'Info';
$lang_module['info_no_permission'] = 'You have not been granted permission to manage laws, please contact your superiors for permission';
$lang_module['msgnocheck'] = 'Please select at least one row to do';
$lang_module['main'] = 'Main';
$lang_module['area'] = 'Area';
$lang_module['area_name'] = 'Area';
$lang_module['cat'] = 'Category';
$lang_module['subject'] = 'Subject';
$lang_module['save'] = 'Save';
$lang_module['add'] = 'Add';
$lang_module['status'] = 'Status';
$lang_module['status1'] = 'Active';
$lang_module['status0'] = 'Unactive';
$lang_module['feature'] = 'Feature';
$lang_module['day'] = 'Day';
$lang_module['there_is_num'] = 'Number of results';
$lang_module['is_required'] = 'Required';
$lang_module['select2_pick'] = 'Enter title or code to search';
$lang_module['hl0'] = 'Enable';
$lang_module['hl1'] = 'Unenable';
$lang_module['e0'] = 'Not passed yet';
$lang_module['e1'] = 'Passed';
$lang_module['add_laws'] = 'Add  a laws';
$lang_module['logChangeWeight'] = 'Weight change';
$lang_module['bodytexterror'] = 'You have not entered the text content for details';
$lang_module['errorCatNotExists'] = 'Error! This category does not exist';
$lang_module['errorCatYesSub'] = 'Error! Maybe the kind under this category. Please remove them first';
$lang_module['errorCatYesRow'] = 'Error! This category contains the text. Please remove them first';
$lang_module['errorCatYesSub1'] = 'There are categories and subcategories, the system ignores it and doesn\'t delete it. Need to delete subcategories in it first';
$lang_module['errorCatYesRow1'] = 'There are categories with law, the system ignores not deletes. Need to delete the law in it first';
$lang_module['errorCatDeleteList'] = 'Other eligible categories (if any) have been removed';
$lang_module['logDelCat'] = 'Delete category';
$lang_module['editCat'] = 'Edit category';
$lang_module['addCat'] = 'Add category';
$lang_module['newicon'] = 'New day';
$lang_module['errorIsExists'] = 'Error! This category is exist';
$lang_module['title'] = 'Title';
$lang_module['alias'] = 'Alias';
$lang_module['catParent'] = 'Category';
$lang_module['catParent0'] = 'Main category';
$lang_module['introduction'] = 'Introduction';
$lang_module['errorIsEmpty'] = 'Error! You did not enter data into the cell';
$lang_module['pos'] = 'ID';
$lang_module['delConfirm'] = 'Do you really want to delete? If you agree, you will not be able to restore data after this!';
$lang_module['errorChangeWeight'] = 'Error! The change order has not been implemented';
$lang_module['keywords'] = 'Keywords';
$lang_module['keywordsNote'] = 'Separated by commas';
$lang_module['addTopicOK'] = 'Success';
$lang_module['logChangeaWeight'] = 'Field Change Order';
$lang_module['errorAreaNotExists'] = 'Error! This field does not exist';
$lang_module['errorAreaYesSub'] = 'Error! Having the field under this sector. Please remove them first';
$lang_module['errorAreaYesRow'] = 'Error! This field contains the text. Please remove them first';
$lang_module['errorAreaYesSub1'] = 'There are areas with subareas, the system ignores not deletes. Need to delete the subareas in it first';
$lang_module['errorAreaYesRow1'] = 'There are area with have laws, that the system ignores and does not delete. Need to delete the laws in it first';
$lang_module['errorAreaDeleteList'] = 'Other eligible areas (if any) have been deleted';
$lang_module['errorAreaYesCode'] = 'Error! You did not enter a written code';
$lang_module['logDelArea'] = 'Delete Field';
$lang_module['editArea'] = 'Edit Field';
$lang_module['addArea'] = 'Add Field';
$lang_module['areaParent'] = 'Area';
$lang_module['areaParent0'] = 'Main area';
$lang_module['logChangesWeight'] = 'Change the order promulgating agency';
$lang_module['errorSubjectNotExists'] = 'Error! The agency issued does not exist';
$lang_module['errorSubjectYesRow'] = 'Error! with the Agency Documents issued under this. Please remove them first';
$lang_module['errorSubjectYesRow1'] = 'There are agencies with law, the system ignores not deletes. Need to delete the law in it first';
$lang_module['errorSubjectDeleteList'] = 'Other eligible agencies (if any) have been removed';
$lang_module['logDelSubject'] = 'Delete Agency';
$lang_module['editSubject'] = 'Edit Agency';
$lang_module['addSubject'] = 'Add Agency';
$lang_module['erroNotSelectCat'] = 'Error! You have not selected Category';
$lang_module['erroNotSelectArea'] = 'Error! You have not selected field';
$lang_module['erroNotSelectSubject'] = 'Error! You have not selected agencies promulgate';
$lang_module['erroNotSelectSinger'] = 'Error! You did not choose him to sign documents';
$lang_module['erroNotSelectPubtime'] = 'Error! You did not choose the date issued documents';
$lang_module['introtext'] = 'Iintrotext';
$lang_module['editRow'] = 'Edit laws';
$lang_module['addRow'] = 'Add laws';
$lang_module['delRow'] = 'Delete laws';
$lang_module['code'] = 'Code';
$lang_module['catSel'] = 'Category';
$lang_module['areaSel'] = 'Area';
$lang_module['subjectSel'] = 'Subject';
$lang_module['bodytext'] = 'Bodytext';
$lang_module['signer'] = 'Signer';
$lang_module['view0'] = 'All';
$lang_module['view1'] = 'Member';
$lang_module['view2'] = 'Admin';
$lang_module['view3'] = 'Member group';
$lang_module['who_view'] = 'View premisstion';
$lang_module['who_download'] = 'Download premisstion';
$lang_module['fileupload'] = 'File upload';
$lang_module['publtime'] = 'Pub time';
$lang_module['exptime'] = 'Exptime';
$lang_module['prm'] = 'Ex: 15.12.2010';
$lang_module['replacement'] = 'Replacement';
$lang_module['amendment'] = 'Amendment';
$lang_module['supplement'] = 'Supplement';
$lang_module['search'] = 'Search';
$lang_module['ID'] = 'ID';
$lang_module['note'] = 'Note';
$lang_module['startvalid'] = 'Startvalid';
$lang_module['relatement'] = 'Relatement';
$lang_module['reset'] = 'Reset';
$lang_module['waiting'] = 'Enter information then click the search button to perform membership';
$lang_module['from'] = 'from';
$lang_module['to'] = 'to';
$lang_module['select'] = 'Select';
$lang_module['noresult'] = 'No result';
$lang_module['enter_key'] = 'Please enter information to a text';
$lang_module['siteinfo_numlaws'] = 'Total number of documents';
$lang_module['error_save'] = 'The system can not store data, please check the table may not be enough data or duplicate';
$lang_module['error_update'] = 'The system can not update data';
$lang_module['signer_list'] = 'List of people sign documents';
$lang_module['signer_title'] = 'Fullname';
$lang_module['signer_offices'] = 'Office';
$lang_module['signer_positions'] = 'Position';
$lang_module['scontent'] = 'Scontent';
$lang_module['scontent_add'] = 'Add scontent';
$lang_module['scontent_edit'] = 'Edit scontent';
$lang_module['scontent_delete'] = 'Delete scontent';
$lang_module['scontent_error_title'] = 'Name of person signing documents should not be empty';
$lang_module['scontent_error_exist'] = 'Error: The sign was there';
$lang_module['config'] = 'Configuration module';
$lang_module['config_nummain'] = 'Number of text at home';
$lang_module['config_numsub'] = 'Number of text in the page';
$lang_module['config_typeview'] = 'View type';
$lang_module['config_down_in_home'] = 'Download on main page';
$lang_module['config_down_in_home_note'] = 'Allows users to download attachments from the laws list, without needing to go to the details page.';
$lang_module['config_detail_other'] = 'Displays laws of the same category';
$lang_module['config_detail_other_cat'] = 'Same category';
$lang_module['config_detail_other_area'] = 'Same area';
$lang_module['config_detail_other_signer'] = 'Same signer';
$lang_module['config_detail_other_subject'] = 'Same agency';
$lang_module['config_detail_other_numlinks'] = 'Number of links of the same type';
$lang_module['config_show_link_detailpage'] = 'Display links when viewing law details in';
$lang_module['config_show_link_detailpage1'] = 'Law category';
$lang_module['config_show_link_detailpage2'] = 'Area';
$lang_module['config_show_link_detailpage3'] = 'Agency';
$lang_module['config_show_link_detailpage4'] = 'Signer';
$lang_module['config_detail_hide_empty_field'] = 'Hide items without information when viewing law details';
$lang_module['config_detail_pdf_quick_view'] = 'Display quick view button for PDF files on the law detail page';
$lang_module['config_tshow'] = 'Show title/abstract when when viewing list form';
$lang_module['config_tshow0'] = 'Show abstract';
$lang_module['config_tshow1'] = 'Show title';
$lang_module['config_tshow2'] = 'Title + Abstract';
$lang_module['type_view_0'] = 'Newest on top';
$lang_module['type_view_1'] = 'Oldest on top';
$lang_module['type_view_2'] = 'Sorted by issuing agency (Only applicable on the home page)';
$lang_module['type_view_3'] = 'On adding law, new on top';
$lang_module['type_view_4'] = 'On adding law, old on top';
$lang_module['wait'] = 'Please wait....';
$lang_module['numlink'] = 'Number links';
$lang_module['search_error'] = 'Choose at least one search terms';
$lang_module['search_cat'] = 'Category';
$lang_module['search_all'] = 'All';
$lang_module['msg1'] = 'You need add';
$lang_module['msg2'] = 'first';
$lang_module['msg3'] = 'Click here';
$lang_module['msg4'] = 'to go to adding page';
$lang_module['msg5'] = 'The system will automatically redirect after 5 seconds.';
$lang_module['activecomm'] = 'Allows for comments';
$lang_module['start_comm_time'] = 'Date of starting consultation';
$lang_module['end_comm_time'] = 'Date of ending consultation';
$lang_module['view_comm'] = 'View comments';
$lang_module['examine'] = 'Inspection agency';
$lang_module['addExamine'] = 'Add Inspection agency';
$lang_module['errorExamineNotExists'] = 'Error! The verification agency does not exist.';
$lang_module['errorExamineYesRow'] = 'Error! There are laws belonging to this Inspection Agency. Let\'s delete them first.';
$lang_module['editExamine'] = 'Edit Inspection agency';
$lang_module['logDelExamine'] = 'Delete Inspection agency';
$lang_module['ExamineSel'] = 'Select Inspection agency';
$lang_module['approval'] = 'Status';
$lang_module['erroStartvalid'] = 'Error! The effective date cannot be before the date of issuance.';
$lang_module['erroExptime'] = 'Error! The expiration date must be after the date of issuance and the effective date.';
$lang_module['admin_add'] = 'Admin add';
$lang_module['admins'] = 'Decentralization of management';
$lang_module['admin_cat_for_user'] = 'Your authority at the issuing agencies';
$lang_module['admin_no_user_title'] = 'There is no module manager yet';
$lang_module['admin_no_user_content'] = 'The decentralization function for this module only applies to module operators. You need to add a module operator before decentralizing.';
$lang_module['content_subject'] = 'Agency issuing law';
$lang_module['permissions_admin'] = 'Management of issuing agencies';
$lang_module['permissions_admin_area'] = 'Management of area';
$lang_module['permissions_add_content'] = 'Add law';
$lang_module['permissions_edit_content'] = 'Edit law';
$lang_module['permissions_del_content'] = 'Delete law';
$lang_module['permissions_pub_error'] = 'Error: You are not allowed to post law at the issuing agency: %1$s';
$lang_module['permissions_sendspadmin_error'] = 'Error: You are not allowed to send law to the editor-in-chief at the issuing agency: %1$s';
$lang_module['permissions_pub_show_error'] = 'Error: You are not allowed to display the law at the issuing agency: %1$s';
$lang_module['admin_cat'] = 'Manage laws according to the issuing agency';
$lang_module['admin_area'] = 'Manage laws by area';
$lang_module['admin_module'] = 'Module management';
$lang_module['admin_full_module'] = 'Full module management';
$lang_module['admin_userid'] = 'ID';
$lang_module['admin_username'] = 'Username';
$lang_module['admin_full_name'] = 'Full name';
$lang_module['admin_first_name'] = 'Last name';
$lang_module['admin_last_name'] = 'First name';
$lang_module['admin_email'] = 'Email';
$lang_module['lastname_firstname'] = 'Full name';
$lang_module['admin_permissions'] = 'Permissions';
$lang_module['admin_edit'] = 'Edit';
$lang_module['admin_edit_user'] = 'Edit user';
$lang_module['admin_area_note'] = 'Note: If you have the right to manage the parent area, you also have the right to manage the child areas within it';
$lang_module['admin_full_note'] = 'Full module rights have the rights of module management, additional rights to configure the module and decentralize other accounts';
$lang_module['admin_note'] = 'Module managers have the right to manage all laws, fields, issuing agencies, verifying agencies (if opinions are sought), people, and categories.';