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
    <!-- BEGIN: navigation -->
    <link href="{ASSETS_STATIC_URL}/js/perfect-scrollbar/style{AUTO_MINIFIED}.css" rel="stylesheet" />
    <script src="{ASSETS_STATIC_URL}/js/perfect-scrollbar/min.js" charset="utf-8"></script>
    <div class="metas">
        <div class="item item-dropdown">
            <span class="item-show" id="law-btn-tableof-contents"><i class="fa fa-list-ol" aria-hidden="true"></i> {LANG.navigation}</span>
            <div class="item-dropdown-container">
                <div class="item-dropdown-content" id="law-tableof-contents">
                    <div class="navigation-body">
                        <ol class="navigation">
                            <!-- BEGIN: navigation_item -->
                            <li>
                                <a href="#" data-scroll-to="{NAVIGATION.1}" data-location="{NAVIGATION.2}">{NAVIGATION.0}</a>
                                <!-- BEGIN: sub_navigation -->
                                <ol class="sub-navigation">
                                    <!-- BEGIN: sub_navigation_item -->
                                    <li>
                                        <a href="#" data-scroll-to="{SUBNAVIGATION.1}" data-location="{SUBNAVIGATION.2}">{SUBNAVIGATION.0}</a>
                                    </li>
                                    <!-- END: sub_navigation_item -->
                                </ol>
                                <!-- END: sub_navigation -->
                            </li>
                            <!-- END: navigation_item -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: navigation -->
    <div class="tab-content tab-content-main">
        <div role="tabpanel" class="tab-pane{ACTIVE_BASIC}" id="doc-basic">
            <div class="panel-body">
                <p class="margin-bottom">{DATA.introtext}</p>
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
                <div class="clearfix"></div>
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
        <!-- BEGIN: maps -->
        <div role="tabpanel" class="tab-pane{ACTIVE_MAPS}" id="doc-maps">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-8 col-md-6">
                        <ul class="docmaps-nav list-unstyled">
                            <!-- BEGIN: nav -->
                            <li class="docmaps-nav-item{NAV_ACTIVE}"><a href="#maps-{NAV_ID}" data-toggle="tab">{NAV_NAME} <span class="text-danger">({NAV_NUM})</span></a></li>
                            <!-- END: nav -->
                        </ul>
                    </div>
                    <div class="col-sm-16 col-md-18">
                        <div class="tab-content">
                            <!-- BEGIN: map -->
                            <div role="tabpanel" class="tab-pane{NAV_ACTIVE}" id="maps-{NAV_ID}">
                                {HTML}
                            </div>
                            <!-- END: map -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: maps -->
    </div>
</div>

<div id="comment"></div>
<!-- BEGIN: comment -->
<div class="panel panel-default">
    <div class="panel-body">
    {CONTENT_COMMENT}
    </div>
</div>
<!-- END: comment -->

<div class="law-detail-other">
    <!-- BEGIN: other_cat -->
    <{OTHER_HEADING} class="margin-bottom{OTHER_CLASS}"><i class="fa fa-file-text-o" aria-hidden="true"></i> {LANG.other_cat} <a href="{DATA.cat_url}" title="{DATA.cat}">"{DATA.cat}"</a></{OTHER_HEADING}>
    {OTHER_CAT}
    <!-- END: other_cat -->

    <!-- BEGIN: other_area -->
    <{OTHER_HEADING} class="margin-bottom{OTHER_CLASS}"><i class="fa fa-file-text-o" aria-hidden="true"></i> {LANG.other_area} <a href="{AREA_TITLE.area_url}" title="{AREA_TITLE.area}">"{AREA_TITLE.area}"</a></{OTHER_HEADING}>
    {OTHER_AREA}
    <!-- END: other_area -->

    <!-- BEGIN: other_subject -->
    <{OTHER_HEADING} class="margin-bottom{OTHER_CLASS}"><i class="fa fa-file-text-o" aria-hidden="true"></i> {LANG.other_subject} <a href="{DATA.subject_url}" title="{DATA.subject}">"{DATA.subject}"</a></{OTHER_HEADING}>
    {OTHER_SUBJECT}
    <!-- END: other_subject -->

    <!-- BEGIN: other_signer -->
    <{OTHER_HEADING} class="margin-bottom{OTHER_CLASS}"><i class="fa fa-file-text-o" aria-hidden="true"></i> {LANG.other_signer} <a href="{DATA.signer_url}" title="{DATA.signer}">"{DATA.signer}"</a></{OTHER_HEADING}>
    {OTHER_SIGNER}
    <!-- END: other_signer -->
</div>
<!-- END: main -->

<!-- BEGIN: mapitems -->
<ul class="list-unstyled mapitems">
    <!-- BEGIN: loop -->
    <li>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="item-title margin-bottom">
                    <span>{ROW.stt}</span>
                    <a href="{ROW.url}">{ROW.title}</a>
                </div>
                <div class="item-meta text-muted">
                    <div class="item">{LANG.code1}: {ROW.code}</div>
                    <!-- BEGIN: publtime --><div class="item">{LANG.publtime1}: {ROW.publtime}</div><!-- END: publtime -->
                    <div class="item">{LANG.s_status}: {ROW.effective_status_show}</div>
                </div>
            </div>
        </div>
    </li>
    <!-- END: loop -->
</ul>
<!-- END: mapitems -->
