<!-- BEGIN: main -->
<h1 class="lawh3">{DATA.title}</h1>
<p>{DATA.introtext}</p>

<!-- BEGIN: field -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr class="hoatim">
                <td style="width:160px" class="text-right">{LANG.code}</td>
                <td>{DATA.code}</td>
            </tr>
            <!-- BEGIN: publtime -->
            <tr class="hoatim">
                <td class="text-right">{LANG.publtime}</td>
                <td>{DATA.publtime}</td>
            </tr>
            <!-- END: publtime -->
            <!-- BEGIN: start_comm_time -->
            <tr class="hoatim">
                <td class="text-right">{LANG.start_comm_time_title}</td>
                <td>{DATA.start_comm_time}</td>
            </tr>
            <!-- END: start_comm_time -->
            <!-- BEGIN: end_comm_time -->
            <tr class="hoatim">
                <td class="text-right">{LANG.end_comm_time_title}</td>
                <td>{DATA.end_comm_time}</td>
            </tr>
            <!-- END: end_comm_time -->
             <!-- BEGIN: approval -->
            <tr class="hoatim">
                <td class="text-right">{LANG.approval}</td>
                <td>{DATA.approval}</td>
            </tr>
            <!-- END: approval -->
            <!-- BEGIN: startvalid -->
            <tr class="hoatim">
                <td class="text-right">{LANG.startvalid}</td>
                <td>{DATA.startvalid}</td>
            </tr>
            <!-- END: startvalid -->
            <!-- BEGIN: exptime -->
            <tr class="hoatim">
                <td class="text-right">{LANG.exptime}</td>
                <td>{DATA.exptime}</td>
            </tr>
            <!-- END: exptime -->
            <!-- BEGIN: cat -->
            <tr class="hoatim">
                <td class="text-right">{LANG.cat}</td>
                <td>
                    <!-- BEGIN: link --><a rel="dofollow" href="{DATA.cat_url}" title="{DATA.cat}">{DATA.cat}</a><!-- END: link -->
                    <!-- BEGIN: text -->{DATA.cat}<!-- END: text -->
                </td>
            </tr>
            <!-- END: cat -->
            <tr class="hoatim">
                <td class="text-right">{LANG.area}</td>
                <td>
                    <!-- BEGIN: area_link --><a rel="dofollow" href="{AREA.url}" title="{AREA.title}">{AREA.title}</a><br /><!-- END: area_link -->
                    <!-- BEGIN: area_text -->{AREA.title}<br /><!-- END: area_text -->
                </td>
            </tr>
            <!-- BEGIN: subject -->
            <tr class="hoatim">
                <td class="text-right">{LANG.subject}</td>
                <td>
                    <!-- BEGIN: link --><a rel="dofollow" href="{DATA.subject_url}" title="{DATA.subject}">{DATA.subject}</a><!-- END: link -->
                    <!-- BEGIN: text -->{DATA.subject}<!-- END: text -->
                </td>
            </tr>
            <!-- END: subject -->
            <!-- BEGIN: examine -->
            <tr class="hoatim">
                <td class="text-right">{LANG.examine}</td>
                <td>
                    {DATA.examine}
                </td>
            </tr>
            <!-- END: examine -->
            <!-- BEGIN: signer -->
            <tr class="hoatim">
                <td class="text-right">{LANG.signer}</td>
                <td>
                    <!-- BEGIN: link --><a rel="dofollow" href="{DATA.signer_url}" title="{DATA.signer}">{DATA.signer}</a><!-- END: link -->
                    <!-- BEGIN: text -->{DATA.signer}<!-- END: text -->
                </td>
            </tr>
            <!-- END: signer -->
            <!-- BEGIN: replacement -->
            <tr>
                <td class="text-right">{LANG.replacement}</td>
                <td>
                    <ul class="list-item">
                        <!-- BEGIN: loop -->
                        <li><a rel="dofollow" href="{replacement.link}" title="{replacement.title}">{replacement.code}</a> - {replacement.title}</li>
                        <!-- END: loop -->
                    </ul>
                </td>
            </tr>
            <!-- END: replacement -->
            <!-- BEGIN: unreplacement -->
            <tr>
                <td class="text-right">{LANG.unreplacement}</td>
                <td>
                    <ul class="list-item">
                        <!-- BEGIN: loop -->
                        <li><a rel="dofollow" href="{unreplacement.link}" title="{unreplacement.title}">{unreplacement.code}</a> - {unreplacement.title}</li>
                        <!-- END: loop -->
                    </ul>
                </td>
            </tr>
            <!-- END: unreplacement -->
            <!-- BEGIN: relatement -->
            <tr>
                <td class="text-right">{LANG.relatement}</td>
                <td>
                    <ul class="list-item">
                        <!-- BEGIN: loop -->
                        <li><a rel="dofollow" href="{relatement.link}" title="{relatement.title}">{relatement.code}</a> - {relatement.title}</li>
                        <!-- END: loop -->
                    </ul>
                </td>
            </tr>
            <!-- END: relatement -->
        </tbody>
    </table>
</div>
<!-- END: field -->

<!-- BEGIN: bodytext -->
<h2 class="lawh3">{LANG.bodytext}</h2>
<p class="m-bottom">{DATA.bodytext}</p>
<!-- END: bodytext -->

<div id="comment"></div>
<!-- BEGIN: files -->
<h2 class="lawh3"><em class="fa fa-download">&nbsp;</em>{LANG.files}</h2>
<div class="list-group laws-download-file">
    <!-- BEGIN: loop -->
    <div class="list-group-item">
        <!-- BEGIN: show_quick_view --><span class="badge"><a rel="dofollow" role="button" data-toggle="collapse" href="#pdf{FILE.key}" aria-expanded="false" aria-controls="pdf{FILE.key}"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-title="{LANG.quick_view_pdf}"></i></a></span><!-- END: show_quick_view -->
        <a rel="dofollow" href="{FILE.url}" title="{FILE.titledown}{FILE.title}">{FILE.titledown}: <strong>{FILE.title}</strong></a>
        <!-- BEGIN: content_quick_view -->
        <div class="clearfix"></div>
        <div class="collapse" id="pdf{FILE.key}" data-src="{FILE.urlpdf}" data-toggle="collapsepdf">
            <div style="height:10px"></div>
            <div class="well">
                <iframe frameborder="0" height="600" scrolling="yes" src="" width="100%"></iframe>
            </div>
        </div>
        <!-- END: content_quick_view -->
    </div>
    <!-- END: loop -->
</div>
<!-- END: files -->

<!-- BEGIN: nodownload -->
<h2 class="lawh3">{LANG.files}</h2>
<p class="text-center m-bottom">{LANG.info_download_no}</p>
<!-- END: nodownload -->

<!-- BEGIN: admin_link -->
<div class="text-right list-group clearfix">
    <a rel="dofollow" class="btn btn-primary btn-xs" href="{DATA.edit_link}"><i class="fa fa-edit"></i> {LANG.edit}</a>
    <a rel="dofollow" class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_delete_law('{LINK_DELETE}', {DATA.id});"><i class="fa fa-trash-o"></i> {LANG.delete}</a>
</div>
<!-- END: admin_link -->

<!-- BEGIN: comment -->
<div class="news_column panel panel-default">
    <div class="panel-body">
    {CONTENT_COMMENT}
    </div>
</div>
<!-- END: comment -->

<!-- BEGIN: other_cat -->
<h2 class="subtitle">{LANG.other_cat} <a rel="dofollow" href="{DATA.cat_url}" title="{DATA.cat}">"{DATA.cat}"</a></h2>
{OTHER_CAT}
<!-- END: other_cat -->

<!-- BEGIN: other_area -->
<h2 class="subtitle">{LANG.other_area} <a href="{AREA_TITLE.area_url}" title="{AREA_TITLE.area}">"{AREA_TITLE.area}"</a></h2>
{OTHER_AREA}
<!-- END: other_area -->

<!-- BEGIN: other_subject -->
<h2 class="subtitle">{LANG.other_subject} <a rel="dofollow" href="{DATA.subject_url}" title="{DATA.subject}">"{DATA.subject}"</a></h2>
{OTHER_SUBJECT}
<!-- END: other_subject -->

<!-- BEGIN: other_signer -->
<h2 class="subtitle">{LANG.other_signer} <a rel="dofollow" href="{DATA.signer_url}" title="{DATA.signer}">"{DATA.signer}"</a></h2>
{OTHER_SIGNER}
<!-- END: other_signer -->

<!-- END: main -->
