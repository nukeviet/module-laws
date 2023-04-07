<!-- BEGIN: dListOption -->
<option{OPTION.style} value="{OPTION.value}"{OPTION.selected}>
    {OPTION.name}
</option>
<!-- END: dListOption -->

<!-- BEGIN: main -->
<div class="form-group">
    <a href="{MODULE_URL}=area&amp;add" class="btn btn-primary">{LANG.addArea}</a>
</div>
<div class="myh3">
    <span><a class="mycat" href="0">{LANG.area}</a></span>
</div>
<div id="pageContent">
    <div style="text-align: center"><em class="fa fa-spinner fa-spin fa-4x">&nbsp;</em><br />{LANG.wait}</div>
</div>
<script type="text/javascript">
$(function() {
    $("div#pageContent").load("{MODULE_URL}=area&list&random=" + nv_randomPassword(10));
});
</script>
<!-- END: main -->

<!-- BEGIN: action -->
<div id="pageContent">
    <form id="addCat" method="post" action="{ACTION_URL}">
        <h3 class="myh3">{PTITLE}</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col class="w200" />
                </colgroup>
                <tbody>
                    <tr>
                        <td>{LANG.title} <span style="color:red">*</span></td>
                        <td>
                            <input title="{LANG.title}" class="form-control" style="width: 300px" type="text" name="title" value="{CAT.title}" maxlength="255" />
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.alias}</td>
                        <td>
                            <div class="input-group w300">
                                <input class="form-control" type="text" name="alias" value="{CAT.alias}" id="id_alias" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-refresh fa-lg" onclick="nv_get_alias('id_alias');">&nbsp;</i>
                                    </button> </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.areaParent}</td>
                        <td>
                            <select class="form-control w300" title="{LANG.areaParent}" name="parentid">
                                <option value="0">{LANG.areaParent0}</option>
                                {PARENTID}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top">{LANG.introduction}</td>
                        <td><textarea class="form-control" style="width: 300px" name="introduction" id="introduction">{CAT.introduction}</textarea></td>
                    </tr>
                    <tr>
                        <td>{LANG.keywords}</td>
                        <td>
                            <label>
                                <input title="{LANG.keywords}" class="form-control" style="width: 300px" type="text" name="keywords" value="{CAT.keywords}" maxlength="255" />
                                ({LANG.keywordsNote})
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="save" value="1" />
        <input class="btn btn-primary" name="btnsubmit" type="submit" value="{LANG.save}" />
    </form>
</div>

<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
    //<![CDATA[
    $("[name='title']").change(function() {
        nv_get_alias('id_alias');
    });
    //]]>
</script>
<!-- END: auto_get_alias -->

<script type="text/javascript">
    //<![CDATA[
    function nv_get_alias(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=area&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title), function(res) {
                $("#" + id).val(strip_tags(res));
            });
        }
        return false;
    }

    $("form#addCat").submit(function() {
        var a = $("input[name=title]").val();
        a = trim(a);
        $("input[name=title]").val(a);
        if (a == "") {
            alert("{LANG.errorIsEmpty}: " + $("input[name=title]").attr("title"));
            $("input[name=title]").select();
            return !1;
        }
        a = $(this).serialize();
        var c = $(this).attr("action");
        $("input[name=btnsubmit]").attr("disabled", "disabled");
        $.ajax({
            type : "POST",
            url : c,
            data : a,
            success : function(b) {
                if (b == "OK") {
                    window.location.href = "{MODULE_URL}=area";
                } else {
                    alert(b);
                    $("input[name=btnsubmit]").removeAttr("disabled");
                }
            }
        });
        return !1;
    });
    //]]>
</script>
<!-- END: action -->

<!-- BEGIN: list -->
<form>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover tab1" summary="{PARENTID}">
            <thead>
                <tr>
                    <th style="width: 1%" class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"></th>
                    <th style="width:100px"> {LANG.pos} </th>
                    <th>{LANG.title}</th>
                    <th style="width:130px">{LANG.feature}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">
                        <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{LOOP.id}" name="idcheck[]">
                    </td>
                    <td>
                        <select name="p_{LOOP.id}" class="form-control newWeight">
                            <!-- BEGIN: option -->
                            <option value="{NEWWEIGHT.value}"{NEWWEIGHT.selected}>{NEWWEIGHT.value}</option>
                            <!-- END: option -->
                        </select>
                    </td>
                    <td>
                        <!-- BEGIN: count -->
                        <a class="yessub" href="{LOOP.id}">{LOOP.title}</a><span class="red">({LOOP.count})</span>
                        <!-- END: count -->

                        <!-- BEGIN: countempty -->
                        {LOOP.title}
                        <!-- END: countempty -->
                    </td>
                    <td>
                        <a href="{MODULE_URL}=area&amp;edit&amp;id={LOOP.id}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                        <a class="del btn btn-danger btn-xs" href="{LOOP.id}"><i class="fa fa-trash"></i> {GLANG.delete}</a>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
    <div class="form-group form-inline">
        <div class="form-group mt-0">
            <select class="form-control" id="action-of-list">
                <option value="delete">{GLANG.delete}</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="nv_area_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')">{GLANG.submit}</button>
    </div>
</form>
<script type="text/javascript">
//<![CDATA[
$("a.yessub").click(function() {
    var a = $(this).attr("href");
    $("div.myh3").append('<span> &raquo; <a class="mycat" href="' + a + '">' + $(this).text() + "</a></span>");
    $("div#pageContent").load("{MODULE_URL}=area&list&parentid=" + a + "&random=" + nv_randomPassword(10));
    return !1;
});
$("a.mycat").click(function() {
    if ($(this).parent().next().text() != "") {
        $(this).parent().nextAll().remove();
        var a = $(this).attr("href"), a = a != "0" ? "&parentid=" + a : "";
        $("div#pageContent").load("{MODULE_URL}=area&list" + a + "&random=" + nv_randomPassword(10));
    }
    return !1;
});
$("a.del").click(function() {
    confirm("{LANG.delConfirm} ?") && $.ajax({
        type : "POST",
        url : "{MODULE_URL}=area",
        data : "del=" + $(this).attr("href"),
        success : function(a) {
            a == "OK" ? window.location.href = window.location.href : alert(a);
        }
    });
    return !1;
});
$("select.newWeight").change(function() {
    var a = $(this).attr("name").split("_"), b = $(this).val(), c = this, a = a[1];
    $(this).attr("disabled", "disabled");
    $.ajax({
        type : "POST",
        url : "{MODULE_URL}=area",
        data : "cWeight=" + b + "&id=" + a,
        success : function(a) {
            a == "OK" ? ( a = $("table.tab1").attr("summary"), $("div#pageContent").load("{MODULE_URL}=area&list&parentid=" + a + "&random=" + nv_randomPassword(10))) : alert("{LANG.errorChangeWeight}");
            $(c).removeAttr("disabled");
        }
    });
    return !1;
});
//]]>
</script>
<!-- END: list -->
