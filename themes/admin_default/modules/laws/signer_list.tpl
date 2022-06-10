<!-- BEGIN: main -->
<div class="form-group">
    <a href="{LINK_ADD}" class="btn btn-primary">{LANG.scontent_add}</a>
</div>
<form class="form-inline" action="{FORM_ACTION}" method="post" name="levelnone" id="levelnone">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center w50"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
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
                        <!-- BEGIN: checkrow -->
                        <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" class="idcheck" name="idcheck[]" />
                        <!-- END: checkrow -->
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
            <tfoot>
                <tr class="text-left">
                    <td colspan="12">
                        <select class="form-control w150" name="action1" id="action1">
                            <!-- BEGIN: action -->
                            <option value="{ACTION.value}">{ACTION.title}</option>
                            <!-- END: action -->
                        </select>
                        <input type="button" class="btn btn-primary"  onclick="nv_main_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')" value="{LANG.action}" />
                    </td>
                </tr>
            </tfoot>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="7">
                        {GENERATE_PAGE}
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
        </table>
    </div>
</form>

<script type="text/javascript">

    function nv_main_action(e, session, msg){
        var action = $('#action1').val();
        if  (action === 'delete'){
           var arr = [];
           var i = 0;
           $('.idcheck:checked').each(function () {
               arr[i++] = $(this).val();
           });  

            if  (arr != []){
                ajax_delete(arr); 
            }
      }   
    }
    
    function ajax_delete(arr){
        data = {
            'delete_action': 1,
            'arr': arr
        }
        $.ajax({
            type: "POST",
            url: "",
            cache: !1,
            data: data,
            success: function (res) {
                if (res == 'OK'){
                    var result = confirm("Bạn thực sự muốn xóa? Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi lại chúng sau này");
                    if (result == true){
                        alert('Lệnh Xóa đã được thực hiện');
                    }
                }else{
                alert('Vì một lý do nào đó lệnh Xóa đã không được thực hiện');
                }
                location.reload();
            }
        })
    }
</script>

<!-- END: main -->

