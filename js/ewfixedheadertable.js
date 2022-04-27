/**
 * Fixed Header Table for PHPMaker 2022
 * @license Copyright (c) e.World Technology Limited. All rights reserved.
 */
ew.fixedHeaderTable = function(options) {
    var $ = jQuery,
        $container = $("#" + options.container).addClass("table-responsive"),
        table = $container.find("table.ew-table").addClass("table-head-fixed ew-fixed-header-table")[0];
        delay = options.delay || 0;

    if (!options.width && !options.height || !table || !table.rows ||
        !$container[0] || !$container.is("div.ew-grid-middle-panel"))
        return;

    var isMobile = function() {
        return ew.IS_MOBILE || !ew.IS_SCREEN_SM_MIN; // customize mobile width here, should match Bootstrap @screen-xs-max
    };

    var getWidth = function() {
        return isMobile() ? "100%" : options.width; // use width = 100% for mobile
    };

    var timer, $window = $(window),
        $grid = $container.closest(".ew-grid").addClass("d-block").css("min-width", 0), // reset from "table" to "block"
        $panels = $grid.find(".ew-grid-lower-panel, .ew-grid-upper-panel"),
        $form = $grid.closest(".ew-form:not(.ew-list-form)"),
        $detailPages = $grid.closest(".ew-detail-pages").css("display", "block"), // reset from "table" to "block"
        $tabPane = $grid.closest(".tab-pane"),
        $tab = $detailPages.find("a[data-bs-toggle=tab][href='#" + $tabPane.attr("id") + "']"),
        $collapse = $grid.closest(".collapse"),
        isDetail = !!$form[0],
        isActive = $tab.hasClass("show") || $collapse.hasClass("show") || !$detailPages[0];

    var setWidths = function() {
        var w = getWidth();
        $grid.width(isDetail ? "100%" : w);
        $panels.innerWidth("100%");
        ew.fixLayoutHeight();
    };

    var init = function() {
        if ($container.data("FixedHeaderTable"))
            return;

        // height => Y scrolling
        var height = options.height,
            yscroll = height,
            width = getWidth();

        // set form width same as grid
        if (isDetail && width)
            $form.width(width);

        // adjust the width/height of the container
        $grid.width(isDetail ? "100%" : width);
        $container.width(width ? "100%" : "").height(height || "100%");

        // check if scrolling
        var container = $container[0];
        yscrolling = container.scrollHeight > container.clientHeight;
        //xscrolling = container.scrollWidth > container.clientWidth;

        // setup the table
        ew.setupTable(-1, table);

        // check last row
        if (yscroll && table.rows && container.clientHeight > table.offsetHeight) {
            var $rows = $(table.rows).filter(":not(.ew-template)");
            var n = $rows.filter("[data-rowindex=1]").length || $rows.filter("[data-rowindex=0]").length || 1;
            $rows.slice(-1 * n).find("td.ew-table-last-row").removeClass("ew-table-last-row").addClass("ew-table-border-bottom");
        }

        // set widths on resize
        var _resize = function() {
            clearTimeout(timer);
            timer = setTimeout(setWidths, 250);
        };

        // bind resize handler
        $window.resize(_resize);

        // pushmenu
        $('[data-widget="pushmenu"]').on("collapsed.lte.pushmenu", _resize).on("shown.lte.pushmenu", _resize);

        // set widths
        setWidths();

        // init scrollbars
        if (ew.USE_OVERLAY_SCROLLBARS)
            $container.overlayScrollbars(ew.overlayScrollbarsOptions);

        // initiated
        $container.data("FixedHeaderTable", true);

    };

    if (isDetail && !isActive) { // if detail grid but not active
        $tab.on("shown.bs.tab", init);
        $collapse.on("shown.bs.collapse", init);
    } else if (delay > 0) {
        $.later(delay, null, init);
    } else if (delay < 0) {
        $(init);
    } else if (delay == 0) {
        init();
    }

}