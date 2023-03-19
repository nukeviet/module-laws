<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr class="header">
            <!-- BEGIN: head_td -->
            <th><a href="{HEAD_TD.href}">{HEAD_TD.title}</a></th>
            <!-- END: head_td -->
            <td style="text-align: center"><strong>{LANG.admin_permissions}</strong></td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <!-- BEGIN: xusers -->
        <tr>
            <td>{CONTENT_TD.userid}</td>
            <td>
                <!-- BEGIN: is_admin --> <img style="vertical-align: middle;" alt="{CONTENT_TD.level}" title="{CONTENT_TD.level}" src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/{CONTENT_TD.img}.png" width="38" height="18" /> <!-- END: is_admin -->{CONTENT_TD.username}
            </td>
            <td>{CONTENT_TD.full_name}</td>
            <td><a href="mailto:{CONTENT_TD.email}">{CONTENT_TD.email}</a></td>
            <td>{CONTENT_TD.admin_module_cat}</td>
            <td class="text-center">
                <!-- BEGIN: is_edit --> <em class="fa fa-edit fa-lg">&nbsp;</em><a href="{EDIT_URL}">{LANG.admin_edit}</a> <!-- END: is_edit -->
            </td>
        </tr>
        <!-- END: xusers -->
    </tbody>
</table>
<!-- BEGIN: edit -->
<form method="post" action="">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong>{CAPTION_EDIT}</strong>
        </div>
        <div class="panel-body">
            <div class="form-inline">
                <label>{LANG.admin_permissions}</label>
                <select class="form-control" name="admin_module">
                    <!-- BEGIN: admin_module -->
                    <option value="{ADMIN_MODULE.value}"{ADMIN_MODULE.selected}>{ADMIN_MODULE.text}</option>
                    <!-- END: admin_module -->
                </select>
            </div>
            <div id="note_admin_area" class="mt-3 text-primary" style="display: none;">{LANG.admin_area_note}</div>
            <div id="note_admin_full" class="mt-3 text-primary" style="display: none;">{LANG.admin_full_note}</div>
            <div id="note_admin" class="mt-3 text-primary" style="display: none;">{LANG.admin_note}</div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="id_admin_subject" style="display: none;">
                <thead>
                    <tr>
                        <th class="text-center">{LANG.content_subject}</th>
                        <th class="text-center" data-toggle="alladd">{LANG.permissions_add_content}</th>
                        <th class="text-center" data-toggle="alledit">{LANG.permissions_edit_content}</th>
                        <th class="text-center" data-toggle="alldel">{LANG.permissions_del_content}</th>
                        <th class="text-center" data-toggle="alladmin">{LANG.permissions_admin}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: catid -->
                    <tr>
                        <td>{CONTENT.title}</td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptadd" name="subject_add[]" value="{CONTENT.subjectid}"{CONTENT.checked_add}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptedit" name="subject_edit[]" value="{CONTENT.subjectid}"{CONTENT.checked_edit}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptdel" name="subject_del[]" value="{CONTENT.subjectid}"{CONTENT.checked_del}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptadmin" name="subject_admin[]" value="{CONTENT.subjectid}"{CONTENT.checked_admin}></td>
                    </tr>
                    <!-- END: catid -->
                </tbody>
            </table>
            <table class="table table-striped table-hover" id="id_admin_area" style="display: none;">
                <thead>
                    <tr>
                        <th class="text-center">{LANG.area_name}</th>
                        <th class="text-center" data-toggle="alladd">{LANG.permissions_add_content}</th>
                        <th class="text-center" data-toggle="alledit">{LANG.permissions_edit_content}</th>
                        <th class="text-center" data-toggle="alldel">{LANG.permissions_del_content}</th>
                        <th class="text-center" data-toggle="alladmin">{LANG.permissions_admin_area}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: area -->
                    <tr>
                        <td>{AREA.name}</td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptadd" name="area_add[]" value="{AREA.id}"{AREA.checked_add}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptedit" name="area_edit[]" value="{AREA.id}"{AREA.checked_edit}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptdel" name="area_del[]" value="{AREA.id}"{AREA.checked_del}></td>
                        <td class="text-center"><input type="checkbox" data-toggle="iptadmin" name="area_admin[]" value="{AREA.id}"{AREA.checked_admin}></td>
                    </tr>
                    <!-- END: area -->
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-center">
            <input class="btn btn-primary" type="submit" value="{LANG.save}" name="saveform">
        </div>
    </div>
</form>
<script type="text/javascript">
function controlView() {
    var tp = $('[name=admin_module]').val();
    if (tp == 0) {
        $("#id_admin_subject").show();
        $("#id_admin_area").hide();
        $("#note_admin_area").hide();
        $("#note_admin_full").hide();
        $("#note_admin").hide();
    } else if (tp == 1) {
        $("#id_admin_subject").hide();
        $("#id_admin_area").show();
        $("#note_admin_area").show();
        $("#note_admin_full").hide();
        $("#note_admin").hide();
    } else {
        $("#id_admin_subject").hide();
        $("#id_admin_area").hide();
        $("#note_admin_area").hide();

        if (tp == 2) {
            $("#note_admin_full").hide();
            $("#note_admin").show();
        } else {
            $("#note_admin_full").show();
            $("#note_admin").hide();
        }
    }
}

function controlChecked(element, type) {
    var ctn = $(element).parent().parent().parent();
    type = 'ipt' + type;
    if ($('[data-toggle="' + type + '"]:checked', ctn).length < 1 || $('[data-toggle="' + type + '"]:checked', ctn).length < $('[data-toggle="' + type + '"]', ctn).length) {
        $('[data-toggle="' + type + '"]', ctn).prop('checked', true);
    } else {
        $('[data-toggle="' + type + '"]', ctn).prop('checked', false);
    }
}

$(document).ready(function() {
    controlView();

    $('[data-toggle="alladd"]').on("dblclick", function() {
        controlChecked(this, 'add');
    });
    $('[data-toggle="alledit"]').on("dblclick", function() {
        controlChecked(this, 'edit');
    });
    $('[data-toggle="alldel"]').on("dblclick", function() {
        controlChecked(this, 'del');
    });
    $('[data-toggle="alladmin"]').on("dblclick", function() {
        controlChecked(this, 'admin');
    });

    $("[name=admin_module]").on('change', function() {
        controlView();
    });
});
</script>
<!-- END: edit -->
<!-- END: main -->
