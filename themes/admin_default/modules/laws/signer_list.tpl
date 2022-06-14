<!-- BEGIN: main -->
<div class="form-group">
    <a href="{LINK_ADD}" class="btn btn-primary">{LANG.scontent_add}</a>
</div>
<form class="form-inline" action="{FORM_ACTION}" method="post" name="levelnone" id="levelnone">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 1%" class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"></th>
                    <th>{LANG.signer_title}</th>
                    <th>{LANG.signer_offices}</th>
                    <th>{LANG.signer_positions}</th>
                    <th style="width:120px" class="text-center">{LANG.feature}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: row -->
                <tr class="topalign">
                    <td class="text-center">
                        <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]">
                    </td>
                    <td><strong>{ROW.title}</strong></td>
                    <td>{ROW.offices}</td>
                    <td>{ROW.positions}</td>
                    <td class="text-center">
                        <em class="fa fa-edit fa-lg">&nbsp;</em><a href="{ROW.url_edit}">{GLANG.edit}</a> -
                        <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="javascript:void(0);" onclick="nv_delete_signer({ROW.id});">{GLANG.delete}</a>
                    </td>
                </tr>
                <!-- END: row -->
            <tbody>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="5">
                        {GENERATE_PAGE}
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
        </table>
    </div>
    <div class="form-group form-inline">
        <div class="form-group mt-0">
            <select class="form-control" id="action-of-signer">
                <option value="delete">{GLANG.delete}</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="nv_signer_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')">{GLANG.submit}</button>
    </div>
</form>
<!-- END: main -->
