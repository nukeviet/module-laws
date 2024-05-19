<!-- BEGIN: main -->
<div class="law-detail{RESPONSIVE}">
    <h1 class="margin-bottom-lg">{DATA.title}</h1>
    <!-- BEGIN: admin_link -->
    <div class="list-group clearfix">
        <a rel="nofollow" class="btn btn-primary btn-xs" href="{DATA.edit_link}"><i class="fa fa-edit"></i> {LANG.edit}</a>
        <a rel="nofollow" class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_delete_law('{LINK_DELETE}', {DATA.id});"><i class="fa fa-trash-o"></i> {LANG.delete}</a>
    </div>
    <!-- END: admin_link -->
    <ul class="nav nav-tabs" role="tablist">
        <!-- BEGIN: tab -->
        <li role="presentation"<!-- BEGIN: active --> class="active"<!-- END: active -->><a href="#{ID}" data-location="{LINK}" aria-controls="{ID}" role="tab" data-toggle="tab">{TITLE}</a></li>
        <!-- END: tab -->
    </ul>
    <div class="metas"></div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane{ACTIVE_BASIC}" id="doc-basic">
            <div class="panel-body">
                <p>{DATA.introtext}</p>
                <!-- BEGIN: properties -->
                <table class="table table-properties table-bordered mb-0">
                    <tbody>
                        <!-- BEGIN: tr -->
                        <tr>
                            <!-- BEGIN: td -->
                            <td class="col-header fw-bold">{COL.label}</td>
                            <td<!-- BEGIN: colspan --> colspan="3"<!-- END: colspan -->>
                                <!-- BEGIN: link --><a href="{COL.link}">{COL.value}</a><!-- END: link -->
                                <!-- BEGIN: text -->{COL.value}<!-- END: text -->
                                <!-- BEGIN: value --><!-- BEGIN: separator -->, <!-- END: separator --><!-- BEGIN: link --><a href="{COL_VALUE.link}">{COL_VALUE.value}</a><!-- END: link --><!-- BEGIN: text -->{COL_VALUE.value}<!-- END: text --><!-- END: value -->
                            </td>
                            <!-- END: td -->
                        </tr>
                        <!-- END: tr -->
                    </tbody>
                </table>
                <!-- END: properties -->
            </div>
        </div>
        <!-- BEGIN: docbody -->
        <div role="tabpanel" class="tab-pane{ACTIVE_BODY}" id="doc-body">
            <div class="panel-body">
                <!-- BEGIN: bodytext -->
                <div class="bodytext">
                    {DATA.bodytext}
                </div>
                <!-- END: bodytext -->
                <!-- BEGIN: fileview -->
                <p class="text-break-hard margin-bottom"><i class="{FILE.icon}"></i> <strong>{FILE.title}</strong>:</p>
                <div class="form-group">
                    <!-- BEGIN: iframe -->
                    <div class="iframe-outer">
                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={FILE.url_encode}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <!-- END: iframe -->
                    <!-- BEGIN: pdf -->
                    <div class="iframe-outer">
                        <iframe src="{FILE.urlpdf}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <!-- END: pdf -->
                    <!-- BEGIN: img -->
                    <div class="text-center">
                        <img class="quickview-image" alt="{DATA.title}" src="{FILE.url}">
                    </div>
                    <!-- END: img -->
                </div>
                <!-- END: fileview -->
            </div>
        </div>
        <!-- END: docbody -->
        <!-- BEGIN: files -->
        <div role="tabpanel" class="tab-pane{ACTIVE_FILES}" id="doc-files">
            <div class="panel-body">
                <div class="h2 fw-bold margin-bottom-lg"><i class="fa fa-download"></i> {LANG.download}</div>
                <!-- BEGIN: noright -->
                <div class="alert alert-warning mb-0">{LANG.info_download_no}</div>
                <!-- END: noright -->
                <!-- BEGIN: content -->
                <div class="list-group laws-download-file mb-0">
                    <!-- BEGIN: loop -->
                    <div class="list-group-item">
                        <div class="download-item">
                            <div class="iicon"><i class="{FILE.icon}"></i></div>
                            <div class="iname">
                                <a rel="nofollow" href="{FILE.url}" title="{FILE.titledown}{FILE.title}">{FILE.titledown}: <strong>{FILE.title}</strong></a>
                            </div>
                            <!-- BEGIN: show_quick_view -->
                            <div class="iview">
                                <a rel="nofollow" role="button" data-toggle="collapse" href="#quickview-{FILE.key}" aria-expanded="false" aria-controls="quickview-{FILE.key}">
                                    <span class="fa-stack" data-toggle="tooltip" data-title="{LANG.quick_view_pdf}">
                                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                                        <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </div>
                            <!-- END: show_quick_view -->
                        </div>
                        <!-- BEGIN: content_quick_view -->
                        <div class="clearfix"></div>
                        <div class="collapse" id="quickview-{FILE.key}" data-pdf="{FILE.urlpdf}" data-url="{FILE.url}" data-type="{FILE.file_type}" data-toggle="collapsepdf">
                            <div class="quickview-holder">&nbsp;</div>
                        </div>
                        <!-- END: content_quick_view -->
                    </div>
                    <!-- END: loop -->
                </div>
                <!-- END: content -->
            </div>
        </div>
        <!-- END: files -->
    </div>
</div>

<div id="comment"></div>
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
