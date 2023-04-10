<!-- BEGIN: main -->
<form method="get" action="{NV_BASE_ADMINURL}index.php">
    <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
    <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_q">{LANG.keywords}:</label>
                <input type="text" class="form-control" id="element_q" name="q" value="{SEARCH.q}" placeholder="{LANG.keywords}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_cid">{LANG.search_cat}:</label>
                <select class="form-control select2" name="cid" id="element_cid">
                    <option value="0">{LANG.search_all}</option>
                    <!-- BEGIN: catParent -->
                    <option value="{CATOPT.id}"{CATOPT.selected}>{CATOPT.name}</option>
                    <!-- END: catParent -->
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_aid">{LANG.area_name}:</label>
                <select class="form-control select2" name="aid" id="element_aid">
                    <option value="0">{LANG.search_all}</option>
                    <!-- BEGIN: alist -->
                    <option value="{ALIST.id}"{ALIST.selected}{ALIST.disabled}>{ALIST.name}</option>
                    <!-- END: alist -->
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_sid">{LANG.subject}:</label>
                <select class="form-control select2" name="sid" id="element_sid">
                    <option value="0">{LANG.search_all}</option>
                    <!-- BEGIN: slist -->
                    <option value="{SLIST.id}"{SLIST.selected}>{SLIST.title}</option>
                    <!-- END: slist -->
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_sgid">{LANG.signer}:</label>
                <select class="form-control select2" name="sgid" id="element_sgid">
                    <option value="0">{LANG.search_all}</option>
                    <!-- BEGIN: sglist -->
                    <option value="{SGLIST.id}"{SGLIST.selected}>{SGLIST.title}</option>
                    <!-- END: sglist -->
                </select>
            </div>
        </div>
        <!-- BEGIN: elist_loop -->
        <div class="col-sm-6">
            <div class="form-group">
                <label for="element_eid">{LANG.examine}:</label>
                <select class="form-control select2" name="eid" id="element_eid">
                    <option value="0">{LANG.search_all}</option>
                    <!-- BEGIN: elist -->
                    <option value="{ELIST.id}"{ELIST.selected}>{ELIST.title}</option>
                    <!-- END: elist -->
                </select>
            </div>
        </div>
        <!-- END: elist_loop -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="visible-sm-block visible-md-block visible-lg-block">&nbsp;</label>
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> {GLANG.search}</button>
                <!-- BEGIN: add -->
                <a href="{LINK_ADD_NEW}" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i> {LANG.add_laws}</a>
                <!-- END: add -->
            </div>
        </div>
    </div>
</form>
<form>
    <p class="text-right">{LANG.there_is_num}: <strong class="text-danger">{NUM_ITEMS}</strong></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 30%" class="text-nowrap">
                        <!-- BEGIN: action_checlall -->
                        <input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                        <!-- END: action_checlall -->
                        <a href="{URL_ORDER_TITLE}">{ICON_ORDER_TITLE} {LANG.title}</a>
                    </th>
                    <!-- BEGIN: col_comment -->
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_START_COMM_TIME}">{ICON_ORDER_START_COMM_TIME} {LANG.start_comm_time}</a>
                    </th>
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_END_COMM_TIME}">{ICON_ORDER_END_COMM_TIME} {LANG.end_comm_time}</a>
                    </th>
                    <!-- END: col_comment -->
                    <!-- BEGIN: col_nocomment -->
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_PUBLTIME}">{ICON_ORDER_PUBLTIME} {LANG.publtime}</a>
                    </th>
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_EXPTIME}">{ICON_ORDER_EXPTIME} {LANG.exptime}</a>
                    </th>
                    <!-- END: col_nocomment -->
                    <th style="width: 15%" class="text-nowrap text-center">{LANG.admin_add}</th>
                    <th style="width: 10%" class="text-nowrap text-center">{LANG.status}</th>
                    <!-- BEGIN: col_tools -->
                    <th style="width: 14%" class="text-nowrap text-center">{LANG.feature}</th>
                    <!-- END: col_tools -->
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td>
                        <div class="law-item-title">
                            <!-- BEGIN: sel -->
                            <div class="i-l">
                                <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]">
                            </div>
                            <!-- END: sel -->
                            <div class="i-r">
                                <a target="_blank" href="{ROW.link}"><strong>{ROW.title}</strong></a>
                                <div class="text-muted">{ROW.code}</div>
                            </div>
                        </div>
                    </td>
                    <!-- BEGIN: col_comment -->
                    <td class="text-nowrap">{ROW.start_comm_time}</td>
                    <td class="text-nowrap">{ROW.end_comm_time}</td>
                    <!-- END: col_comment -->
                    <!-- BEGIN: col_nocomment -->
                    <td class="text-nowrap">{ROW.publtime}</td>
                    <td class="text-nowrap">{ROW.exptime}</td>
                    <!-- END: col_nocomment -->
                    <td>{ROW.admin_add}</td>
                    <td class="text-center">
                        <!-- BEGIN: status_action -->
                        <input name="status" id="change_status{ROW.id}" value="1" type="checkbox"{ROW.status_render} onclick="nv_change_status('{ROW.id}');">
                        <!-- END: status_action -->
                        <!-- BEGIN: status_text -->
                        {ROW.status_text}
                        <!-- END: status_text -->
                    </td>
                    <!-- BEGIN: tools -->
                    <td class="text-center">
                        <!-- BEGIN: edit -->
                        <a href="{ROW.url_edit}" class="btn btn-xs btn-default btn-space"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                        <!-- END: edit -->
                        <!-- BEGIN: delete -->
                        <a href="javascript:void(0);" onclick="nv_delete_law('{ROW.id}');" class="btn btn-xs btn-danger btn-space"><i class="fa fa-trash"></i> {GLANG.delete}</a>
                        <!-- END: delete -->
                        <!-- BEGIN: view_comment -->
                        <a href="{ROW.url_view_comm}" class="btn btn-xs btn-info btn-space"><i class="fa fa-eye"></i> {LANG.view_comm}</a>
                        <!-- END: view_comment -->
                    </td>
                    <!-- END: tools -->
                </tr>
                <!-- END: loop -->
            </tbody>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="{NUM_COLS}">
                        {GENERATE_PAGE}
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
        </table>
    </div>
    <!-- BEGIN: action_btns -->
    <div class="form-group form-inline">
        <div class="form-group">
            <select class="form-control" id="action-of-main">
                <option value="delete">{GLANG.delete}</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="nv_main_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')">{GLANG.submit}</button>
    </div>
    <!-- END: action_btns -->
</form>
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_DATA}.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2({
        width: '100%'
    });
});
</script>
<!-- END: main -->
