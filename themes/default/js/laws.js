/**
 * @Project NUKEVIET 4.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Wed, 27 Jul 2011 14:55:22 GMT
 */

function nv_delete_law(url, id) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(url + '&nocache=' + new Date().getTime(), 'del=1&id=' + id, function(res) {
            if (res == 'OK') {
                location.reload();
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
}

$(function() {
    $('.laws-download-file [data-toggle="tooltip"]').tooltip({
       container: "body"
    });
    $('[data-toggle="collapsepdf"]').each(function() {
        $('#' + $(this).attr('id')).on('shown.bs.collapse', function() {
            var $this = $(this);
            var html = '<div class="quickview-holder">&nbsp;</div>';
            if ($this.data('type') == 'image') {
                html += '<div class="text-center"><img class="quickview-image" alt="" src="' + $this.data('url') + '"></div>';
            } else if ($this.data('type') == 'pdf') {
                html += '<div class="iframe-outer"><iframe src="' + $this.data('pdf') + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            } else {
                html += '<div class="iframe-outer"><iframe src="https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURI($this.data('url')) + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            }
            $this.html(html);
        });

        $('#' + $(this).attr('id')).on('hidden.bs.collapse', function() {
            $(this).html('<div class="quickview-holder">&nbsp;</div>');
        });
    });
});
