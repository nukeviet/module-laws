<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<div id="pageContent">
    <form id="addRow" action="{DATA.action_url}" method="post">
        <p><span class="red">*</span> {LANG.is_required}</p>
        <!-- BEGIN: error -->
        <div class="alert alert-danger">{ERROR}</div>
        <!-- END: error -->
        <div class="row">
            <div class="col-sm-24 col-md-18">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <col style="width: 200px" />
                        <tbody>
                            <tr>
                                <td>{LANG.title} <span class="red">*</span></td>
                                <td><input title="{LANG.title}" class="form-control" style="width: 400px" type="text" name="title" value="{DATA.title}" maxlength="255" /></td>
                            </tr>
                            <tr>
                                <td>{LANG.code} <span class="red">*</span></td>
                                <td><input title="{LANG.code}" class="form-control" style="width: 400px" type="text" name="code" value="{DATA.code}" maxlength="255" /></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">{LANG.fileupload} <strong>[<a onclick="nv_add_files('{NV_BASE_ADMINURL}','{UPLOADS_DIR_USER}','{GLANG.delete}','Browse server');" href="javascript:void(0);" title="{LANG.add}">{LANG.add}]</a></strong></td>
                                <td>
                                    <div id="filearea">
                                        <!-- BEGIN: files -->
                                        <div id="fileitem_{FILEUPL.id}" style="margin-bottom: 5px">
                                            <input title="{LANG.fileupload}" class="form-control w400 pull-left" type="text" name="files[]" id="fileupload_{FILEUPL.id}" value="{FILEUPL.value}" style="margin-right: 5px" /> <input onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=fileupload_{FILEUPL.id}&path={UPLOADS_DIR_USER}&type=file', 'NVImg', '850', '500', 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );return false;" type="button" value="Browse server" class="selectfile btn btn-primary" /> <input onclick="nv_delete_datacontent('fileitem_{FILEUPL.id}');return false;" type="button" value="{GLANG.delete}" class="selectfile btn btn-danger" />
                                        </div>
                                        <!-- END: files -->
                                    </div>
                                </td>
                            </tr>
                            <!-- BEGIN: comment -->
                            <tr class="form-inline">
                                <td>{LANG.start_comm_time}</td>
                                <td>
                                    <label>
                                        <input autocomplete="off" class="form-control" name="start_comm_time" id="start_comm_time" value="{DATA.start_comm_time}" style="width: 110px;" maxlength="10" type="text" /> &nbsp;({LANG.prm})
                                    </label>
                                </td>
                            </tr>
                            <tr class="form-inline">
                                <td>{LANG.end_comm_time}</td>
                                <td>
                                    <label>
                                        <input autocomplete="off" class="form-control" name="end_comm_time" id="end_comm_time" value="{DATA.end_comm_time}" style="width: 110px;" maxlength="10" type="text" /> &nbsp;({LANG.prm})
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>{LANG.approval}</td>
                                <td>
                                    <select class="form-control" name="approval" style="width: 200px">
                                        <option value="0"{DATA.e0}>{LANG.e0}</option>
                                        <option value="1"{DATA.e1}>{LANG.e1}</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- END: comment-->
                            <!-- BEGIN: normal_laws -->
                            <tr class="form-inline">
                                <td>{LANG.publtime} <span class="red">*</span></td>
                                <td>
                                    <label>
                                        <input autocomplete="off" class="form-control" name="publtime" id="publtime" value="{DATA.publtime}" style="width: 110px;" maxlength="10" type="text" /> &nbsp;({LANG.prm})
                                    </label>
                                </td>
                            </tr>
                            <tr class="form-inline">
                                <td>{LANG.startvalid}</td>
                                <td>
                                    <label>
                                        <input autocomplete="off" class="form-control" name="startvalid" id="startvalid" value="{DATA.startvalid}" style="width: 110px;" maxlength="10" type="text" /> &nbsp;({LANG.prm})
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>{LANG.exptime}</td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group mb-0">
                                            <select class="form-control" id="chooseexptime" name="chooseexptime" style="width: 200px">
                                                <option value="0"{DATA.select0}>{LANG.hl0}</option>
                                                <option value="1"{DATA.select1}>{LANG.hl1}</option>
                                            </select>
                                        </div>
                                        <div id="exptimearea" class="form-group mt-xs-2 mb-0{DATA.display}">
                                            <input autocomplete="off" class="form-control" name="exptime" id="exptime" value="{DATA.exptime}" style="width: 110px;" maxlength="10" type="text" /> ({LANG.prm})
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#chooseexptime').change(function() {
                                            if ($(this).val() == 0) {
                                                $('#exptime').val('');
                                                $('#exptimearea').addClass('hidden');
                                            } else {
                                                $('#exptimearea').removeClass('hidden');
                                            }
                                        });
                                    });
                                    </script>
                                </td>
                            </tr>
                            <!-- END: normal_laws -->
                            <tr>
                                <td>{LANG.replacement} ({LANG.ID})</td>
                                <td><input class="form-control" title="{LANG.replacement}" type="text" name="replacement" id="replacement" style="width: 200px;" maxlength="255" value="{DATA.replacement}" /></td>
                            </tr>
                            <tr>
                                <td>{LANG.relatement} ({LANG.ID})</td>
                                <td><input class="form-control" title="{LANG.relatement}" type="text" name="relatement" id="relatement" style="width: 200px;" maxlength="255" value="{DATA.relatement}" /></td>
                            </tr>
                            <tr>
                                <td>{LANG.keywords}</td>
                                <td><label> <input title="{LANG.keywords}" class="form-control" style="width: 400px" type="text" name="keywords" value="{DATA.keywords}" maxlength="255" /> ({LANG.keywordsNote})
                                </label></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">{LANG.note}</td>
                                <td><textarea class="form-control" name="note" id="note">{DATA.note}</textarea></td>
                            </tr>
                            <tr>
                                <td>{LANG.introtext} <span class="red">*</span></td>
                                <td><textarea class="form-control" rows="5" name="introtext" id="introtext">{DATA.introtext}</textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2">{CONTENT}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-24 col-md-6">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>{LANG.catSel} <span class="red">*</span></td>
                        </tr>
                        <tr>
                            <td><select class="form-control select2" title="{LANG.catSel}" name="cid" id="cid">
                                    <!-- BEGIN: catopt -->
                                    <option value="{CATOPT.id}"{CATOPT.selected}>{CATOPT.name}</option>
                                    <!-- END: catopt -->
                            </select></td>
                        </tr>
                        <tr>
                            <td>{LANG.areaSel} <span class="red">*</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="height: 200px; overflow: scroll">
                                    <!-- BEGIN: areaopt -->
                                    <label class="show"><input{AREAOPT.disabled} type="checkbox" name="aid[]" value="{AREAOPT.id}" {AREAOPT.checked} />{AREAOPT.name}</label>
                                    <!-- END: areaopt -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{LANG.subjectSel} <span class="red">*</span></td>
                        </tr>
                        <tr>
                            <td><select class="form-control select2" title="{LANG.subjectSel}" name="sid">
                                    <!-- BEGIN: subopt -->
                                    <option value="{SUBOPT.id}"{SUBOPT.selected}>{SUBOPT.title}</option>
                                    <!-- END: subopt -->
                            </select></td>
                        </tr>
                        <!-- BEGIN: loop -->
                        <tr>
                            <td>{LANG.ExamineSel}</td>
                        </tr>
                        <tr>
                            <td><select class="form-control select2" title="{LANG.ExamineSel}" name="eid">
                                    <!-- BEGIN: exbopt -->
                                    <option value="{EXBOPT.id}"{EXBOPT.selected}>{EXBOPT.title}</option>
                                    <!-- END: exbopt -->
                            </select></td>
                        </tr>
                        <!-- END: loop -->
                        <tr>
                            <td>{LANG.signer} <span class="red">*</span></td>
                        </tr>
                        <tr>
                            <td><select class="form-control" title="{LANG.signer}" name="sgid" id="signer">
                                    <!-- BEGIN: singers -->
                                    <option value="{SINGER.id}"{SINGER.selected}>{SINGER.title}</option>
                                    <!-- END: singers -->
                            </select></td>
                        </tr>
                        <tr>
                            <td>{LANG.who_view}</td>
                        </tr>
                        <tr>
                            <td>
                                <!-- BEGIN: group_view -->
                                <div class="row">
                                    <label> <input name="groups_view[]" type="checkbox" value="{GROUPS_VIEWS.id}" {GROUPS_VIEWS.checked} /> {GROUPS_VIEWS.title}
                                    </label>
                                </div>
                                <!-- END: group_view -->
                            </td>
                        </tr>
                        <tr>
                            <td>{LANG.who_download}</td>
                        </tr>
                        <tr>
                            <td>
                                <!-- BEGIN: groups_download -->
                                <div class="row">
                                    <label> <input name="groups_download[]" type="checkbox" value="{GROUPS_DOWNLOAD.id}" {GROUPS_DOWNLOAD.checked} /> {GROUPS_DOWNLOAD.title}
                                    </label>
                                </div>
                                <!-- END: groups_download -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" name="save" value="1" /> <input class="btn btn-primary" name="bntsubmit" type="submit" value="{LANG.save}" />
    </form>
</div>
<script type="text/javascript">
$("#publtime,#startvalid,#end_comm_time,#start_comm_time,#exptime").datepicker({
    showOn : "both",
    yearRange: "2000:2055",
    dateFormat : "dd.mm.yy",
    changeMonth : true,
    changeYear : true,
    showOtherMonths : true,
    buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
    buttonImageOnly : true
});

var nv_num_files = '{NUMFILE}';

$(document).ready(function() {
    $('.select2').select2();
    $('#signer').select2({
        tags: true,
        multiple: false,
        tokenSeparators: [',']
    });

    $("#replacementSearch").click(function() {
        nv_open_browse("{NV_BASE_ADMINURL}index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=getlid&area=replacement", "NVImg", "850", "600", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
    $("#amendmentSearch").click(function() {
        nv_open_browse("{NV_BASE_ADMINURL}index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=getlid&area=amendment", "NVImg", "850", "600", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
    $("#supplementSearch").click(function() {
        nv_open_browse("{NV_BASE_ADMINURL}index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=getlid&area=supplement", "NVImg", "850", "600", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
});
</script>
<!-- END: main -->
