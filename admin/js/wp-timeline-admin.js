;
"use strict";
var wtladmin = {
    init: function() {
        $ = jQuery;
        this.advance_post_contents();
        this.on_change_advance_post_contents();
        this.advance_contents_settings();
        this.on_change_advance_contents_settings();
        this.loader_animation();
        this.load_layou_config();
        this.select_template();
        this.hide_field_for_layout();
    },
    current_layout: function() { return $(".wp_timeline_template_name").val() },
    get_shortcut_id: function() {
        var l = $('.wp-timeline-shortcode-div').attr('lid');
        if (l) {
            return l
        }
    },
    is_horizontal: function() {
        v = $('input[name="layout_type"]:checked').val();
        if (v == 1) {
            return true
        }
    },
    load_layou_config() {
        l = this.current_layout();
        if (l == 'advanced_layout' || l == 'hire_layout' || l == 'curve_layout') {
            $('.display_layout_type').show();
        } else {
            $('.display_layout_type').hide();
        }
    },
    advance_post_contents: function() {
        a = $('.advance_contents_settings');
        b = $('.advance_contents_settings_character');
        c = $("select[name='contents_stopage_from']").val();
        if ($('input[name="advance_contents"]:checked').val() == 1) {
            a.show();
            if (c == 'character') {
                b.show()
            } else {
                b.hide()
            }
        } else {
            a.hide();
            if (c == 'character') {
                b.show()
            } else {
                b.hide()
            }
            b.hide();
        }
    },
    on_change_advance_post_contents: function() {
        $('input[name="advance_contents"]').on(
            'change',
            function() {
                wtladmin.advance_post_contents();
            }
        );
    },
    advance_contents_settings: function() {
        a = $(".advance_contents_settings_character");
        if ($('input[name="advance_contents"]:checked').val() == 0) {
            if ($("select[name='contents_stopage_from']").val() == 'character') {
                a.show()
            } else {
                a.hide()
            }
            a.hide()
        }
    },
    on_change_advance_contents_settings: function() {
        $("select[name='contents_stopage_from']").on('change', function() { wtladmin.advance_contents_settings() });
    },
    loader_animation: function() {
        var loaders = {
            circularG: '<div class="wtl-circularG-wrapper"><div class="wtl-circularG wtl-circularG_1"></div><div class="wtl-circularG wtl-circularG_2"></div><div class="wtl-circularG wtl-circularG_3"></div><div class="wtl-circularG wtl-circularG_4"></div><div class="wtl-circularG wtl-circularG_5"></div><div class="wtl-circularG wtl-circularG_6"></div><div class="wtl-circularG wtl-circularG_7"></div><div class="wtl-circularG wtl-circularG_8"></div></div>',
            floatingCirclesG: '<div class="wtl-floatingCirclesG"><div class="wtl-f_circleG wtl-frotateG_01"></div><div class="wtl-f_circleG wtl-frotateG_02"></div><div class="wtl-f_circleG wtl-frotateG_03"></div><div class="wtl-f_circleG wtl-frotateG_04"></div><div class="wtl-f_circleG wtl-frotateG_05"></div><div class="wtl-f_circleG wtl-frotateG_06"></div><div class="wtl-frotateG_07 wtl-f_circleG"></div><div class="wtl-frotateG_08 wtl-f_circleG"></div></div>',
            spinloader: '<div class="wtl-spinloader"></div>',
            doublecircle: '<div class="wtl-doublec-container"><ul class="wtl-doublec-flex-container"><li><span class="wtl-doublec-loading"></span></li></ul></div>',
            wBall: '<div class="wtl-windows8"><div class="wtl-wBall wtl-wBall_1"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_2"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_3"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall wtl-wBall_4"><div class="wtl-wInnerBall"></div></div><div class="wtl-wBall_5 wtl-wBall"><div class="wtl-wInnerBall"></div></div></div>',
            cssanim: '<div class="wtl-cssload-aim"></div>',
            thecube: '<div class="wtl-cssload-thecube"><div class="wtl-cssload-cube wtl-cssload-c1"></div><div class="wtl-cssload-cube wtl-cssload-c2"></div><div class="wtl-cssload-cube wtl-cssload-c4"></div><div class="wtl-cssload-cube wtl-cssload-c3"></div></div>',
            ballloader: '<div class="wtl-ballloader"><div class="wtl-loader-inner wtl-ball-grid-pulse"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>',
            squareloader: '<div class="wtl-squareloader"><div class="wtl-square"></div><div class="wtl-square"></div><div class="wtl-square last"></div><div class="wtl-square clear"></div><div class="wtl-square"></div><div class="wtl-square last"></div><div class="wtl-square clear"></div><div class="wtl-square"></div><div class="wtl-square last"></div></div>',
            loadFacebookG: '<div class="wtl-loadFacebookG"><div class="wtl-blockG_1 wtl-facebook_blockG"></div><div class="wtl-blockG_2 wtl-facebook_blockG"></div><div class="wtl-facebook_blockG wtl-blockG_3"></div></div>',
            floatBarsG: '<div class="wtl-floatBarsG-wrapper"><div class="wtl-floatBarsG_1 wtl-floatBarsG"></div><div class="wtl-floatBarsG_2 wtl-floatBarsG"></div><div class="wtl-floatBarsG_3 wtl-floatBarsG"></div><div class="wtl-floatBarsG_4 wtl-floatBarsG"></div><div class="wtl-floatBarsG_5 wtl-floatBarsG"></div><div class="wtl-floatBarsG_6 wtl-floatBarsG"></div><div class="wtl-floatBarsG_7 wtl-floatBarsG"></div><div class="wtl-floatBarsG_8 wtl-floatBarsG"></div></div>',
            movingBallG: '<div class="wtl-movingBallG-wrapper"><div class="wtl-movingBallLineG"></div><div class="wtl-movingBallG_1 wtl-movingBallG"></div></div>',
            ballsWaveG: '<div class="wtl-ballsWaveG-wrapper"><div class="wtl-ballsWaveG_1 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_2 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_3 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_4 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_5 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_6 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_7 wtl-ballsWaveG"></div><div class="wtl-ballsWaveG_8 wtl-ballsWaveG"></div></div>',
            fountainG: '<div class="fountainG-wrapper"><div class="wtl-fountainG_1 wtl-fountainG"></div><div class="wtl-fountainG_2 wtl-fountainG"></div><div class="wtl-fountainG_3 wtl-fountainG"></div><div class="wtl-fountainG_4 wtl-fountainG"></div><div class="wtl-fountainG_5 wtl-fountainG"></div><div class="wtl-fountainG_6 wtl-fountainG"></div><div class="wtl-fountainG_7 wtl-fountainG"></div><div class="wtl-fountainG_8 wtl-fountainG"></div></div>',
            audio_wave: '<div class="wtl-audio_wave"><span></span><span></span><span></span><span></span><span></span></div>',
            warningGradientBarLineG: '<div class="wtl-warningGradientOuterBarG"><div class="wtl-warningGradientFrontBarG wtl-warningGradientAnimationG"><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div><div class="wtl-warningGradientBarLineG"></div></div></div>',
            floatingBarsG: '<div class="wtl-floatingBarsG"><div class="wtl-rotateG_01 wtl-blockG"></div><div class="wtl-rotateG_02 wtl-blockG"></div><div class="wtl-rotateG_03 wtl-blockG"></div><div class="wtl-rotateG_04 wtl-blockG"></div><div class="wtl-rotateG_05 wtl-blockG"></div><div class="wtl-rotateG_06 wtl-blockG"></div><div class="wtl-rotateG_07 wtl-blockG"></div><div class="wtl-rotateG_08 wtl-blockG"></div></div>',
            rotatecircle: '<div class="wtl-cssload-loader"><div class="wtl-cssload-inner wtl-cssload-one"></div><div class="wtl-cssload-inner wtl-cssload-two"></div><div class="wtl-cssload-inner wtl-cssload-three"></div></div>',
            overlay_loader: '<div class="wtl-overlay-loader"><div class="wtl-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>',
            circlewave: '<div class="wtl-circlewave"></div>',
            cssload_ball: '<div class="wtl-cssload-ball"></div>',
            cssheart: '<div class="wtl-cssload-main"><div class="wtl-cssload-heart"><span class="wtl-cssload-heartL"></span><span class="wtl-cssload-heartR"></span><span class="wtl-cssload-square"></span></div><div class="wtl-cssload-shadow"></div></div>',
            spinload: '<div class="wtl-spinload-loading"><i></i><i></i><i></i></div>',
            bigball: '<div class="wtl-bigball-container"><div class="wtl-bigball-loading"><i></i><i></i><i></i></div></div>',
            bubblec: '<div class="wtl-bubble-container"><div class="wtl-bubble-loading"><i></i><i></i></div></div>',
            csball: '<div class="wtl-csball-container"><div class="wtl-csball-loading"><i></i><i></i><i></i><i></i></div></div>',
            ccball: '<div class="wtl-ccball-container"><div class="wtl-ccball-loading"><i></i><i></i></div></div>',
            circulardot: '<div class="wtl-cssload-wrap"><div class="wtl-circulardot-container"><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span><span class="wtl-cssload-dots"></span></div></div>',
        };
        $(".wp_timeline_select_loader").on(
            'click',
            function(e) {
                e.preventDefault();
                $(".wp-timeline-loader-popupdiv").dialog({ title: 'Select Loader', dialogClass: 'wp_timeline_template_model', width: $(window).width() - 216, height: $(window).height() - 100, modal: true, draggable: false, resizable: false });
                var $loader_style = $('#loader_style_hidden').val();

                $('.wp-timeline-loader-style-box .wp-timeline-dialog-loader-style').each(
                    function() {
                        $(this).removeClass('wp-timeline-active-loader');
                        if ($(this).hasClass($loader_style)) {
                            $(this).addClass('wp-timeline-active-loader');
                        }
                    }
                );
                return false;
            }
        );
        $(".wp-timeline-dialog-loader-style").on(
            'click',
            function(e) {
                var loader_val = $(this).children('input.wp-timeline-loader-style-hidden').val();
                $(".loader_style_hidden").val(loader_val);
                $(".loader_hidden").html();
                if (loader_val != 'audio_wave') {
                    var loader_val_new = loader_val.replace('-', '_');
                } else {
                    var loader_val_new = loader_val;
                }
                $(".loader_hidden").html(loaders[loader_val_new]);
                $("#popuploaderdiv").dialog("close");
            }
        );
        wtladmin.loader_custom();
    },
    loader_custom: function() {
        $("select[name='loader_type']").on(
            'change',
            function() {
                if ($(this).val() != 1) {
                    $(".default_loader").show();
                    $(".upload_loader").hide()
                } else {
                    $(".default_loader").hide();
                    $(".upload_loader").show()
                }
            }
        );
    },
    setOptionVisibility: function(t) {
        var r = ["soft_block", "fullwidth_layout"];
        t = $.trim(t);
        s = $('.wtl-back-color-soft-block');
        if ($.inArray(t, r) !== -1) {
            s.show();
            $('.blog-templatecolor-tr').hide()
        } else {
            s.hide()
        }
    },
    select_template: function() {
        $(".wp-timeline-edit-layout .wp_timeline_select_template").on(
            'click',
            function(e) {
                e.preventDefault();
                var tmplt = $('.wp_timeline_template_name');
                var template_name = tmplt.val();
                $("#popupdiv").dialog({
                    title: wp_timeline_js.choose_blog_template,
                    dialogClass: 'wp_timeline_template_model',
                    width: $(window).width() - 216,
                    height: $(window).height() - 100,
                    modal: true,
                    draggable: false,
                    resizable: false,
                    create: function(e, ui) {
                        var pane = $(this).dialog("widget").find(".ui-dialog-buttonpane");
                        var checked = '';
                        if (tmplt.hasClass('wp-timeline-create-shortcode')) {
                            checked = 'checked=checked';
                        }
                        $("<div class='wp-timeline-div-default-style'><label><input id='wp-timeline-apply-default-style' class='wp-timeline-apply-default-style' type='checkbox' " + checked + "/>" + wp_timeline_js.default_style_template + "</label></div>").prependTo(pane);
                    },
                    buttons: [{
                            text: wp_timeline_js.set_blog_template,
                            id: "btnSetBlogTemplate",
                            click: function() {
                                var template_src = $('#popupdiv div.template-thumbnail.wp_timeline_selected_template .template-thumbnail-inner').children('img').attr('src');
                                if (typeof template_src === 'undefined' || template_src === null) {
                                    $("#popupdiv").dialog('close');
                                    return
                                }
                                var template_name = $('#popupdiv div.template-thumbnail.wp_timeline_selected_template .wp-timeline-span-template-name').html();
                                var template_value = $('#popupdiv div.template-thumbnail.wp_timeline_selected_template .template-thumbnail-inner').children('img').attr('data-value');
                                $(".select_button_upper_div .wp_timeline_selected_template_image > div").empty();
                                tmplt.val(template_value);
                                $(".select_button_upper_div .wp_timeline_selected_template_image > div").append('<img src="' + template_src + '" alt="' + template_name + '" /><label id="template_select_name">' + template_name + ' </label>');
                                $("#popupdiv").dialog('close');
                                if ($('#wp-timeline-apply-default-style').is(":checked")) {
                                    $("input[name=wp_timeline_color_preset][value=" + tmplt.val() + "_default]").attr('checked', 'checked');
                                    lid = $('.wp-timeline-shortcode-div').attr('lid');
                                    if (lid) {
                                        wtladmin.reset_layout_to_default(); /* Reset field for current layout */
                                       
                                    } else {
                                        wtladmin.reset_layout_when_new();
                                    }

                                }
                                if ($('#wp-timeline-apply-default-style').is(":checked")) {
                                    wtladmin.reset_layout_when_new();
                                    setTimeout(function () {
                                        $(".bloglyout_savebtn").trigger("click");
                                    }, 100);
                                }
                                wtladmin.horizontalSetting();
                                wtladmin.hide_field_for_layout(); /* Hide Fields for current layout */
                                wtladmin.setOptionVisibility(tmplt.val());
                                wtladmin.disable_link_chk();
                                wtladmin.blog_background_image();
                                dcp = 'div.controls_preset';
                                $(dcp).hide();
                                $(dcp + '.' + tmplt.val()).show();
                                wtladmin.wp_timelineAltBackground();
                                wtladmin.load_layou_config();
                            }
                        },
                        { text: wp_timeline_js.close, class: 'wp_timeline_template_close', click: function() { $(this).dialog("close") } }
                    ],
                    open: function(event, ui) {
                        pdt = $('#popupdiv .template-thumbnail');
                        pdt.removeClass('wp_timeline_selected_template');
                        pdt.each(
                            function() {
                                if ($(this).children('.template-thumbnail-inner').children('img').attr('data-value') == template_name) {
                                    $(this).addClass('wp_timeline_selected_template');
                                }
                            }
                        );
                        $('body.wp-timeline_page_add_wtl_shortcode').css('position', 'relative').css('overflow', 'hidden');
                        $('.wp-timeline-blog-template-search-cover #wp-timeline-template-search').val('');
                        var $template_name = '';
                        wtladmin.blogTemplateSearch($template_name)
                        $('.wp-timeline-blog-template-cover .template-thumbnail').each(
                            function() {
                                var tplbl = $(this).data('value');
                                if (tplbl != '' && tplbl != undefined) {
                                    $(this).append('<div class="wp-timeline-label">' + tplbl + '</div>')
                                }
                            }
                        );
                    },
                    close: function(event, ui) {
                        $('body.wp-timeline_page_add_wtl_shortcode').css('position', 'unset').css('overflow', 'visible');
                        $('.wp-timeline-blog-template-search-cover #wp-timeline-template-search').val('');
                    }
                });
                return false;
            }
        );
    },
    template_search: function() {
        $('.wp-timeline-blog-template-search-cover #wp-timeline-template-search').keyup(
            function() {
                var $template_name = $(this).val();
                wtladmin.blogTemplateSearch($template_name);
            }
        );
        $('.wp-timeline-blog-template-search-cover .wp-timeline-template-search-clear').on(
            'click',
            function() {
                $('.wp-timeline-blog-template-search-cover #wp-timeline-template-search').val('');
                var $template_name = '';
                wtladmin.blogTemplateSearch($template_name);
            }
        );
    },
    controls_preset: function() {
        var c = $('.wp_timeline_template_name').val();
        d = 'div.controls_preset';
        $(d).hide();
        $(d + c).show();
        $('div.color-option.preset').on(
            'click',
            function() {
                $(this).find('input.of-radio-color').attr('checked', 'checked');
                var v = $(this).data('value');
                if (v) {
                    var l = v.split(',');
                    $.each(
                        l,
                        function(i) {
                            var sc = l[i].split(':');
                            $('#' + sc[0]).iris('color', sc[1])
                        }
                    )
                }
            }
        );
    },
    custom_css: function() {
        if ($('#custom_css').length) {
            if (wp_timeline_js.wp_version >= '4.9') {
                var es = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
                es.codemirror = _.extend({}, es.codemirror, { indentUnit: 2, tabSize: 2, mode: 'css' });
                var editor = wp.codeEditor.initialize($('#custom_css'), es)
            }
        }
    },
    setLayout: function() {
        $("#popupdiv div.template-thumbnail .popup-select a").on(
            'click',
            function(e) {
                e.preventDefault();
                $('#popupdiv div.template-thumbnail').removeClass('wp_timeline_selected_template');
                $(this).parents('div.template-thumbnail').addClass('wp_timeline_selected_template');
            }
        );
    },
    onTabClick: function() {
        $('.wp-timeline-form-class .wp-timeline-setting-handle > li').on(
            'click',
            function(event) {
                if ($(this).hasClass('clickDisable')) {
                    wtladmin.clickDisable();
                } else {
                    var cl = $(this).data('show');
                    $('.wp-timeline-form-class .wp-timeline-setting-handle > li').removeClass('wp-timeline-active-tab');
                    $(this).addClass('wp-timeline-active-tab');
                    $('.wp-timeline-settings-wrappers .postbox').hide();
                    $('#' + cl).show();
                    $('#' + cl + ' .inside').show();
                    $.post(ajaxurl, { action: 'wtl_closed_boxes', closed: cl, page: $('.wp_timeline_originalpage').val() });
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
    },
    clickDisable: function() {
        $('.clickDisable').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            e.stopImmediatePropagation();
            return false
        });
    },
    applySettings: function() {
        var ttfsi = '#template_titlefontsizeInput',
            tptfsi = '#template_postTitlefontsizeInput',
            flfss = '#firstletter_fontsize_slider',
            cfss = '#content_fontsize_slider',
            mfss = '#meta_fontsize_slider',
            dfss = '#date_fontsize_slider',
            bltfs = '#beforeloop_titlefontsizeInput',
            pfsi = '#wp_timeline_pricefontsizeInput',
            epfsi = '#wp_timeline_edd_pricefontsizeInput',
            rpfs = '#related_post_fontsize',
            ssfs = '#social_share_fontsize',
            acfss = '#author_content_fontsize_slider',
            ttpmi = '#template_template_post_marginInput',
            tibri = '#template_icon_border_radiousInput',
            acbfsi = '#wp_timeline_addtocart_button_fontsizeInput',
            awbfsi = '#wp_timeline_addtowishlist_button_fontsizeInput',
            stfsi = '#wp_timeline_sale_tagfontsizeInput',
            rmfss = '#readmore_fontsize_slider',
            eacbfs = '#wp_timeline_edd_addtocart_button_fontsizeInput',
            irsv = 'input.range-slider__value';
        $('.slider_controls div').on('click', function() { $(this).find($('input')).attr('checked', 'checked') });
        $(ttfsi + ',' + tptfsi + ',' + flfss + ',' + cfss + ',' +mfss + ',' + dfss + ',' + bltfs + ',' + pfsi + ',' + epfsi + ',' + rpfs + ',' + ssfs + ',' + acfss + ',' + ttpmi + ',' + tibri + ',' + acbfsi + ',' + awbfsi + ',' + stfsi + ',' + rmfss + ',' + eacbfs + ',#wp_timeline_time_period_dayInput').slider({ range: "min", value: 1, step: 1, min: 0, max: 100, slide: function(e, ui) { $(this).parent().find(irsv).val(ui.value) } });
        var pm = $(ttpmi + ',' + tibri).parent().find(irsv).val(),
            tfsz = $(ttfsi).parent().find(irsv).val(),
            ptfsz = $(tptfsi).parent().find(irsv).val(),
            flfsz = $(flfss).parent().find(irsv).val(),
            cnfsz = $(cfss).parent().find(irsv).val(),
            dnfsz = $(dfss).parent().find(irsv).val(),
            blfsz = $(bltfs).parent().find(irsv).val(),
            pfsz = $(pfsi).parent().find(irsv).val(),
            epfsz = $(epfsi).parent().find(irsv).val(),
            stgfz = $(stfsi).parent().find(irsv).val(),
            acbfz = $(acbfsi).parent().find(irsv).val(),
            ecbfz = $(eacbfs).parent().find(irsv).val(),
            awlbz = $(awbfsi).parent().find(irsv).val(),
            actsz = $(acfss).parent().find(irsv).val(),
            rpfsz = $(rpfs).parent().find(irsv).val(),
            ssfsz = $(ssfs).parent().find(irsv).val(),
            rmfsz = $(rmfss).parent().find(irsv).val();
            mfssz = $(mfss).parent().find(irsv).val(); 
        $(ttpmi + "," + tibri).slider("value", pm);
        $(ttfsi).slider("value", tfsz);
        $(tptfsi).slider("value", ptfsz);
        $(flfss).slider("value", flfsz);
        $(cfss).slider("value", cnfsz);
        $(dfss).slider("value", dnfsz);
        $(bltfs).slider("value", blfsz);
        $(pfsi).slider("value", pfsz);
        $(epfsi).slider("value", epfsz);
        $(stfsi).slider("value", stgfz);
        $(acbfsi).slider("value", acbfz);
        $(awbfsi).slider("value", awlbz);
        $(eacbfs).slider("value", ecbfz);
        $(acfss).slider("value", actsz);
        $(rpfs).slider("value", rpfsz);
        $(ssfs).slider("value", ssfsz);
        $(rmfss).slider("value", rmfsz);
        $(mfss).slider("value", mfssz);
        var gin = '#grid_col_spaceInputId';
        $(gin).slider({ range: "min", value: 1, step: 1, min: 0, max: 50, slide: function(event, ui) { $("#grid_col_spaceOutputId").val(ui.value) } });
        var gs = $("#grid_col_spaceOutputId").val();
        $(gin).slider("value", gs);
        $("#grid_col_spaceOutputId").on(
            'change',
            function() {
                var vl = this.value;
                var mx = 50;
                if (vl > mx) {
                    $(gin).slider("value", '50');
                    $(this).val('50')
                } else {
                    $(gin).slider("value", parseInt(vl))
                }
            }
        );
        var edlyf = '#edit_layout_form';

        $(
            edlyf + ' #date_font_family,' +
            edlyf + ' #template_titlefontface,' +
            edlyf + ' #content_font_family,' +
            edlyf + ' #meta_font_family,' +
            edlyf + ' #readmore_font_family,' +
            edlyf + ' #firstletter_font_family,' +
            edlyf + ' #beforeloop_titlefontface,' +
            edlyf + ' #content_font_family,' +
            edlyf + ' #wp_timeline_sale_tagfontface,' +
            edlyf + ' #wp_timeline_pricefontface,' +
            edlyf + ' #wp_timeline_addtocart_button_fontface,' +
            edlyf + ' #wp_timeline_addtowishlist_button_fontface,' +
            edlyf + ' #wp_timeline_edd_pricefontface,' +
            edlyf + ' #wp_timeline_edd_addtocart_button_fontface'
        ).on(
            'change',
            function() {
                var nm = $(this).attr('name');
                var sd = $(':selected', this);
                var lb = sd.closest('optgroup').attr('label');
                $('#' + nm + '_font_type').val(lb)
            }
        );
        $(".range_slider_days").slider({ range: "min", value: $('.range_slider_days').data('value'), step: 1, min: 0, max: 365, slide: function(event, ui) { $(this).next().find('.range-slider__value_day').val(ui.value) } });
        /** Date picker */
        var btdfm = $('#between_two_date_from'),
            btdto = $('#between_two_date_to'),
            tlhct = $('.title-link-hover-color-tr'),
            inwptl = 'input[name="wp_timeline_post_title_link"]',
            explen = $('.excerpt_length'),
            adcntr = $('.advance_contents_tr'),
            inrmlc = $("input[name='read_more_link']:checked"),
            rmlnk = $('.display_read_more_link'),
            rmtxt = $('.read_more_text'),
            rmtxc = $('.read_more_text_color'),
            rmtxb = $('.read_more_text_background'),
            rmtxh = $('.read_more_text_hover_background'),
            rmtxr = $('.read_more_button_border_radius_setting'),
            rmtxs = $('.read_more_button_border_setting'),
            rmtxg = $('.read_more_text_typography_setting'),
            rmtxo = $("input[name='read_more_on']:checked"),
            pcfrm = $('.post_content_from'),
            pcfrn = $('.display_html_tags_tr'),
            pcfro = $('.display_read_more_on');

        if (btdfm.length >= 1) {
            btdfm.datepicker({ onSelect: function(date) { btdto.datepicker("option", "minDate", date); } })
        };
        if (btdto.length >= 1) {
            btdto.datepicker({})
        }
        /** Show hide option */
        if ($(inwptl + ':checked').val() == 0) {
            tlhct.hide()
        } else {
            tlhct.show()
        }
        $(inwptl).on(
            'click',
            function() {
                if ($(inwptl + ':checked').val() == 0) {
                    tlhct.hide()
                } else {
                    tlhct.show()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
        if ($("input[name='rss_use_excerpt']:checked").val() == 1) {
            explen.show();
            adcntr.show();
            if (inrmlc.val() == 1) {
                $('.read_more_wrap').show();
                rmtxt.show();
                rmtxc.show();
                rmtxb.show();
                if (rmtxo.val() == 1) {
                    rmtxb.hide();
                    rmtxh.hide();
                    rmtxr.hide();
                    rmtxs.hide();
                    rmtxg.hide()
                }
            } else if (inrmlc.val() == 0) {
                rmtxt.hide();
                rmtxc.hide();
                rmtxb.hide();
                rmtxh.hide();
                rmtxr.hide();
                rmtxs.hide();
                $('.read_more_button_alignment_setting').hide();
                $('.read_more_wrap').hide()
            };
            pcfrm.show();
            pcfrn.show()
            rmlnk.show();
        } else {
            rmlnk.hide();
            explen.hide();
            adcntr.hide();
            rmtxt.hide();
            rmtxc.hide();
            rmtxb.hide();
            pcfrm.hide();
            pcfrn.hide();
            pcfro.hide()
        };

        $("input[name='rss_use_excerpt']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    explen.show();
                    adcntr.show();
                    rmlnk.show();
                    if (inrmlc.val() == 1) {
                        rmtxt.show();
                        rmtxc.show();
                        rmtxb.show();
                        if (rmtxo.val() == 1) {
                            rmtxb.hide();
                            rmtxh.hide();
                            rmtxr.hide();
                            rmtxs.hide();
                            rmtxg.hide()
                        } else {
                            rmtxb.show();
                            rmtxh.show();
                            rmtxr.show();
                            rmtxs.show()
                        }
                    } else {
                        rmtxt.hide();
                        rmtxc.hide();
                        rmtxb.hide()
                    };
                    $('.remove_html_tags_tr').show();
                    pcfrm.show();
                    pcfrn.show()
                } else {
                    rmlnk.hide();
                    explen.hide();
                    adcntr.hide();
                    rmtxt.hide();
                    rmtxc.hide();
                    rmtxb.hide();
                    pcfrm.hide();
                    pcfrn.hide();
                    $('.remove_html_tags_tr').hide()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
        // product settings
        var stpwrp = '.wp_timeline_sale_setting',
            srpwrp = '.wp_timeline_star_rating_setting',
            ppwrp = '.wp_timeline_price_setting',
            acbpwrp = '.wp_timeline_cart_button_setting',
            awbpwrp = '.wp_timeline_wishlist_button_setting';

        $("input[name='display_sale_tag']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(stpwrp).show()
                } else {
                    $(stpwrp).hide()
                }
            }
        );
        $("input[name='display_product_rating']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(srpwrp).show()
                } else {
                    $(srpwrp).hide()
                }
            }
        );
        $("input[name='display_product_price']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(ppwrp).show()
                } else {
                    $(ppwrp).hide()
                }
            }
        );
        $("input[name='display_addtocart_button']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(acbpwrp).show()
                } else {
                    $(acbpwrp).hide()
                }
            }
        );
        $("input[name='display_addtowishlist_button']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(awbpwrp).show()
                } else {
                    $(awbpwrp).hide()
                }
            }
        );

        if ($("input[name='display_sale_tag']:checked").val() == 1) {
            $(stpwrp).show()
        } else {
            $(stpwrp).hide()
        }
        if ($("input[name='display_product_rating']:checked").val() == 1) {
            $(srpwrp).show()
        } else {
            $(srpwrp).hide()
        }
        if ($("input[name='display_product_price']:checked").val() == 1) {
            $(ppwrp).show()
        } else {
            $(ppwrp).hide()
        }
        if ($("input[name='display_addtocart_button']:checked").val() == 1) {
            $(acbpwrp).show()
        } else {
            $(acbpwrp).hide()
        }
        if ($("input[name='display_addtowishlist_button']:checked").val() == 1) {
            $(awbpwrp).show()
        } else {
            $(awbpwrp).hide()
        }

        var rmwrp = '.read_more_wrap',
            clurl = '.custom_link_url';
        if (inrmlc.val() == 1) {
            $(rmwrp).show()
        } else {
            $(rmwrp).hide()
        };
        $("input[name='read_more_link']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(rmwrp).show();
                    $(clurl).hide()
                } else {
                    $(rmwrp).hide()
                }
                wtladmin.wp_timelineAltBackground()
            }
        );
        $("input[name='post_link_type']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    $(clurl).show()
                } else {
                    $(clurl).hide()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
        /**  Pagination */
        var snpgt = "select[name='pagination_template']",
            pgbwp = '.wp-timeline-pagination-border-wrap',
            pgabw = '.wp-timeline-pagination-active-border-wrap',
            pgbgc = '.wp-timeline-pagination-background-color';
        $(snpgt).on(
            'change',
            function() {
                var imgname = $(snpgt).val();
                var imgpath = plugin_path + '/images/pagination/' + imgname + '.png';
                $(".pagination_template_images").attr("src", imgpath);
                wtladmin.wp_timelineAltBackground();
            }
        );
        $("select[name='filter_template']").on(
            'change',
            function() {
                var imgname = $("select[name='filter_template']").val();
                var imgpath = plugin_path + '/images/filter/' + imgname + '.png';
                $(".filter_template_images").attr("src", imgpath);
                wtladmin.wp_timelineAltBackground();
            }
        );
        if ($(snpgt).val() == 'template-4') {
            $(pgbwp).show();
            $(pgabw).show()
        } else if ($(snpgt).val() == 'template-1') {
            $(pgbwp).hide();
            $(pgabw).hide()
        } else if ($(snpgt).val() == 'template-2') {
            $(pgbwp).show();
            $(pgabw).hide()
        } else if ($(snpgt).val() == 'template-3') {
            $(pgbwp).show();
            $(pgabw).hide()
        } else {
            $(pgbwp).hide();
            $(pgbgc).show()
        }
        $(snpgt).on(
            'change',
            function() {
                if ($(this).val() == 'template-4') {
                    $(pgbwp).show();
                    $(pgabw).show()
                } else if ($(this).val() == 'template-1') {
                    $(pgbwp).hide();
                    $(pgabw).hide()
                } else if ($(this).val() == 'template-2') {
                    $(pgbwp).show();
                    $(pgabw).hide()
                } else if ($(this).val() == 'template-3') {
                    $(pgbwp).show();
                    $(pgabw).hide()
                } else {
                    $(pgbwp).hide();
                    $(pgabw).hide();
                    $('.wp-timeline-pagination-hover-background-color').show();
                    $(pgbgc).show()
                }
            }
        );

        $("select[name='load_more_button_template']").on(
            'change',
            function() {
                var imgname = $("select[name='load_more_button_template']").val();
                var imgpath = plugin_path + '/images/buttons/' + imgname + '.png';
                $(".load_more_button_template_images").attr("src", imgpath);
                wtladmin.wp_timelineAltBackground();
            }
        );
        /* First Letter Setting show hide*/
        var infbg = 'input[name="firstletter_big"]',
            uwtst = 'ul.wp-timeline-settings',
            fltsg = '.firstletter-setting';
        if ($(infbg + ':checked').val() == 0) {
            $(infbg).closest(uwtst).find(fltsg).hide()
        } else {
            $(infbg).closest(uwtst).find(fltsg).show()
        };
        $(infbg).on(
            'click',
            function() {
                if ($(infbg + ':checked').val() == 0) {
                    $(this).closest(uwtst).find(fltsg).hide()
                } else {
                    $(this).closest(uwtst).find(fltsg).show()
                };
                wtladmin.wp_timelineAltBackground()
            }
        );
        /* Timeline Icon */
        var hticon = 'input[name="hide_timeline_icon"]';
        var ticon = $('.wtl-post-timeline-icon');
        if ($(hticon + ':checked').val() == 1) {
            ticon.hide()
        } else {
            ticon.show()
        }
        $(hticon).on(
            'click',
            function() {
                if ($(hticon + ':checked').val() == 1) {
                    ticon.hide()
                } else {
                    ticon.show()
                }
            }
        );

    },
    title_maxlineSettings: function() {
        var tmn = $('.post_title_maxline_num');
        if ($("input[name='wp_timeline_post_title_maxline']:checked").val() == 1) {
            tmn.show();
        } else {
            tmn.hide();
        }
        $('input[name="wp_timeline_post_title_maxline"]').on(
            'change',
            function() {
                if ($("input[name='wp_timeline_post_title_maxline']:checked").val() == 1) {
                    tmn.show();
                } else {
                    tmn.hide();
                }
            }
        );
    },
    mediaSettings: function() {
        var md = $('.wtl_mdsfild');
        if ($("input[name='wp_timeline_enable_media']:checked").val() == 1) {
            md.show();
            $('.lazy_load_tr.lazy_load_section_li').show();
            $('.lazy_load_blurred_section_li').show();
            $('.lazy_load_color_section_li').show();
        } else {
            md.hide();
            $('.lazy_load_tr.lazy_load_section_li').hide();
            $('.lazy_load_blurred_section_li').hide();
            $('.lazy_load_color_section_li').hide();
        }
        $('input[name="wp_timeline_enable_media"]').on(
            'change',
            function() {
                if ($("input[name='wp_timeline_enable_media']:checked").val() == 1) {
                    md.show();
                    $('.wp-timeline-image-hover-effect-tr').hide();
                    $('.lazy_load_tr.lazy_load_section_li').show();
                    $('.wp_timeline_media_custom_size_tr').hide();
                    // $('.lazy_load_blurred_section_li').show();
                    // $('.lazy_load_color_section_li').show();
                } else {
                    md.hide();
                    $('.lazy_load_tr.lazy_load_section_li').hide();
                    $('.lazy_load_blurred_section_li').hide();
                    $('.lazy_load_color_section_li').hide();
                  }
            }
        );
        var bsi = $('.lazy_load_blurred_section_li');
        var lc = $('.lazy_load_color_section_li');
        if ($("input[name='wp_timeline_lazy_load_image']:checked").val() == 1) {
            bsi.show();
            lc.show();
        } else {
            bsi.hide();
            lc.hide();
        }
        $('input[name="wp_timeline_lazy_load_image"]').on('change', function () {
            if ($("input[name='wp_timeline_lazy_load_image']:checked").val() == 1) {
                bsi.show();
                lc.show();
            } else {
                bsi.hide();
                lc.hide();
            }
        });
    },
    horizontalSetting: function() {
        var md = $('li[data-show="wp_timeline"]');
        var page = $('li[data-show="wp_timeline_pagination"]');
        var cl = this.current_layout();

        if ($("input[name='layout_type']:checked").val() == 2) {
            md.addClass('clickDisable');
            page.removeClass('clickDisable');
        } else {
            md.removeClass('clickDisable');
            page.addClass('clickDisable');
        }
        $('input[name="layout_type"]').on(
            'change',
            function() {
                if ($("input[name='layout_type']:checked").val() == 1) {
                    md.removeClass('clickDisable');
                    page.addClass('clickDisable');
                } else {
                    md.addClass('clickDisable');
                    page.removeClass('clickDisable');
                }
            }
        );
        if ($("input[name='enable_autoslide']:checked").val() == 1) {
            $('.wtl_hz_ts_8').show();
        } else {
            $('.wtl_hz_ts_8').hide();
        }
        $('input[name="enable_autoslide"]').on('change',function() {
                if ($("input[name='enable_autoslide']:checked").val() == 1) {
                    $('.wtl_hz_ts_8').show();
                } else {
                    $('.wtl_hz_ts_8').hide();
                }
            });
    },
    socialShare: function() {
        var ss = $('.social_share_options');
        if ($("input[name='social_share']:checked").val() == 1) {
            ss.show()
        } else {
            ss.hide()
        }
        $('input[name="social_share"]').on(
            'change',
            function() {
                if ($("input[name='social_share']:checked").val() == 1) {
                    ss.show()
                    if ($('input[name="social_style"]:checked').val() == 0) {
                        $('.shape_social_icon,.size_social_icon').show();
                        $('.default_icon_layouts').hide();
                    } else {
                        $('.shape_social_icon,.size_social_icon').hide();
                        $('.default_icon_layouts').show();
                    }
                } else {
                    ss.hide()
                }
            }
        );
        if ($("input[name='social_share']:checked").val() == 1) {
            if ($('input[name="social_style"]:checked').val() == 0) {
                $('.shape_social_icon,.size_social_icon').show();
                $('.default_icon_layouts').hide();
            } else {
                $('.shape_social_icon,.size_social_icon').hide();
                $('.default_icon_layouts').show();
            }
        } else {
            $('.social_share_options').hide();
        }
        $('input[name="social_style"]').on(
            'change',
            function() {
                if ($('input[name="social_style"]:checked').val() == 0) {
                    $('.shape_social_icon,.size_social_icon').show();
                    $('.default_icon_layouts').hide();
                } else {
                    $('.shape_social_icon,.size_social_icon').hide();
                    $('.default_icon_layouts').show();
                }
            }
        );
    },
    uploadImage: function() {
        $(document).on(
            'click',
            '.wp-timeline-upload_image_button',
            function(e) {
                e.preventDefault();
                var frame, elm = $(this);
                var prid = elm.closest('div');
                if (frame) {
                    frame.open();
                    return
                };
                frame = wp.media({ title: elm.data('choose'), button: { text: elm.data('update'), close: false }, multiple: false, library: { type: 'image' } });
                frame.on(
                    'select',
                    function() {
                        var attachment = frame.state().get('selection').first();
                        frame.close(attachment);
                        prid.find('span.wp_timeline_default_image_holder').empty().hide().append('<img src="' + attachment.attributes.url + '">').slideDown('fast');
                        var bgimg = 'wp_timeline_bg_image';
                        if (elm.hasClass(bgimg)) {
                            prid.find('#' + bgimg + '_id').val(attachment.attributes.id);
                            prid.find('#' + bgimg + '_src').val(attachment.attributes.url)
                        } else {
                            prid.find('#wp_timeline_default_image_id').val(attachment.attributes.id);
                            prid.find('#wp_timeline_default_image_src').val(attachment.attributes.url)
                        };
                        elm.removeClass('wp-timeline-upload_image_button');
                        elm.addClass('wp-timeline-remove_image_button');
                        elm.val('');
                        elm.val('Remove Image')
                    }
                );
                frame.open()
            }
        );
        $(document).on(
            'click',
            '.wp-timeline-remove_image_button',
            function(event) {
                event.preventDefault();
                var elm = $(this);
                if (elm.hasClass("wp_timeline_bg_image")) {
                    $('.wp_timeline_bg_image.wp_timeline_default_image_holder > img').slideDown().remove();
                    $('#wp_timeline_bg_image_id').val('');
                    $('#wp_timeline_bg_image_src').val('');
                    elm.addClass('wp-timeline-upload_image_button');
                    elm.removeClass('wp-timeline-remove_image_button');
                    elm.val('');
                    elm.val('Upload Image')
                } else {
                    $('.wp_timeline_default_image_holder > img').slideDown().remove();
                    $('#wp_timeline_default_image_id').val('');
                    $('#wp_timeline_default_image_src').val('');
                    elm.addClass('wp-timeline-upload_image_button');
                    elm.removeClass('wp-timeline-remove_image_button');
                    elm.val('');
                    elm.val('Upload Image')
                }
            }
        );
        $(document).on(
            'click',
            '.wp-timeline-loader_upload_image_button',
            function(event) {
                event.preventDefault();
                var frame;
                var elm = $(this);
                var prid = elm.closest('li');
                if (frame) {
                    frame.open();
                    return
                };
                frame = wp.media({
                    title: elm.data('choose'),
                    button: { text: elm.data('update') },
                    multiple: false,
                    library: { type: 'image' }
                });
                frame.on(
                    'select',
                    function() {
                        var attachment = frame.state().get('selection').first();
                        frame.close(attachment);
                        prid.find('span.wp_timeline_loader_image_holder').empty().hide().append('<img src="' + attachment.attributes.url + '">').slideDown('fast');
                        console.error(attachment.attributes.id);
                        console.error(attachment.attributes.url);
                        prid.find('#wp_timeline_loader_image_id').val(attachment.attributes.id);
                        prid.find('#wp_timeline_loader_image_src').val(attachment.attributes.url);
                        elm.removeClass('wp-timeline-loader_upload_image_button');
                        elm.addClass('wp-timeline-remove_upload_image_button');
                        elm.val('');
                        elm.val('Remove Image');
                    }
                );
                frame.open()
            }
        );
        $(document).on('click', '.wp-timeline-remove_upload_image_button', function(event) {
            event.preventDefault();
            var elm = $(this);
            $('.wp_timeline_loader_image_holder > img').slideDown().remove();
            $('#wp_timeline_loader_image_id').val('');
            $('#wp_timeline_loader_image_src').val('');
            elm.addClass('wp-timeline-loader_upload_image_button');
            elm.removeClass('wp-timeline-remove_upload_image_button');
            elm.val('');
            elm.val('Upload Image')
        });

        var ihetr = $('.wp-timeline-image-hover-effect-tr');
        ihetr.hide();
        if ($("input[name='wp_timeline_enable_media']:checked").val() == 1 && $("input[name='wp_timeline_image_hover_effect']:checked").val() == 1) {
            ihetr.show()
        } else {
            ihetr.hide()
        };
        $("input[name='wp_timeline_image_hover_effect']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    ihetr.show()
                } else {
                    ihetr.hide()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
        var mcstr = $('.wp_timeline_media_custom_size_tr');
        mcstr.hide();
        if ($('#wp_timeline_media_size').val() == 'custom') {
            mcstr.show();
        } else {
            mcstr.hide();
        }
        $('#wp_timeline_media_size').on(
            'change',
            function() {
                if ($(this).val() == 'custom') {
                    mcstr.show()
                } else {
                    mcstr.hide()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
    },
    sortFilterPageination: function() {
        var bttdt = $('.wp_timeline_between_two_date'),
            tpdays = $('.wp_timeline_time_period_days'),
            btprid = $('#blog_time_period'),
            snboby = $("select[name='wp_timeline_blog_order_by']"),
            sobyfr = $('.wp_timeline_sort_by_front'),
            adftop = $('.advance_filter_option');
        bttdt.hide();
        tpdays.hide();
        if (btprid.val() == 'between_two_date') {
            bttdt.show()
        };
        if (btprid.val() == 'last_n_days' || btprid.val() == 'next_n_days') {
            tpdays.show()
        } else {
            tpdays.hide()
        };
        btprid.on(
            'change',
            function() {
                if ($(this).val() == 'between_two_date') {
                    bttdt.show()
                } else {
                    bttdt.hide()
                }
                if ($(this).val() == 'last_n_days' || $(this).val() == 'next_n_days') {
                    tpdays.show()
                } else {
                    tpdays.hide()
                }
            }
        );
        snboby.next('div.blg_order').show();
        if (snboby.val() == '' || snboby.val() == 'rand') {
            $('.wtl_blog_order_by .blg_order').hide();
        }
        snboby.on(
            'change',
            function() {
                if ($(this).val() == '' || $(this).val() == 'rand') {
                    $('div.blg_order').hide()
                } else {
                    $('div.blg_order').show()
                }
                wtladmin.wp_timelineAltBackground();
            }
        );

        sobyfr.hide();
        if ($("input[name='wp_timeline_display_sort_by']:checked").val() == 1) {
            sobyfr.show();
        }
        $("input[name='wp_timeline_display_sort_by']").on(
            'change',
            function() {
                sobyfr.hide();
                if ($(this).val() == 1) {
                    sobyfr.show()
                }
            }
        );
        $("input[name='advance_filter']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    adftop.show()
                } else {
                    adftop.hide()
                };
                wtladmin.wp_timelineAltBackground();
            }
        );
        if ($("select[name='custom_post_type']").val() == 'post') {
            if ($("input[name='advance_filter']:checked").val() == 1) {
                adftop.show()
            } else {
                adftop.hide()
            }
        } else {
            adftop.hide();
        };
        if ($("input[name='display_filter']:checked").val() == 1) {
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == 'wp_timeline_pagination') {
                        $(this).addClass('clickDisable');
                    }
                }
            );
            $('.wp_timeline_posts_per_page').hide();
            $('.wp_timeline_pagination_type').hide();
            $('.wp_template_pagination_template').hide();

        } else {
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == 'wp_timeline_pagination') {
                        $(this).removeClass('clickDisable');
                    }
                }
            );
            $('.wp_timeline_posts_per_page').show();
            $('.wp_timeline_pagination_type').show();
            $('.wp_template_pagination_template').show();
        }

        if ($('#pagination_type').val() == 'no_pagination') {
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == 'wp_timeline_customreadmore') {
                        $(this).removeClass('clickDisable');
                    }
                }
            );
        }
        wtladmin.paginationTypeSelection();

        $("select[name='pagination_type']").on(
            'change',
            function() {
                if ($(this).val() == 'paged') {
                    $(".wp_template_pagination_template").show();
                    $('.loadmore_btn_option').hide();
                } else {
                    $(".wp_template_pagination_template").hide();
                }
                if ($(this).val() == 'load_more_btn' || $(this).val() == 'load_onscroll_btn') {
                    $(".wp_template_loader_template").show();
                    if ($(this).val() == 'load_more_btn') {
                        $('.loadmore_btn_option').show();
                    } else {
                        $('.loadmore_btn_option').hide();
                    }
                    if ($("select[name='loader_type']").val() != 1) {
                        $(".default_loader").show();
                        $(".upload_loader").hide();
                    } else if ($(this).val() == 'load_more_btn' || $(this).val() == 'load_onscroll_btn') {
                        $(".default_loader").hide();
                        $(".upload_loader").show();
                        wtladmin.wp_timelineAltBackground();
                    }
                    wtladmin.wp_timelineAltBackground();
                } else {
                    $(".wp_template_loader_template").hide();
                }
                wtladmin.wp_timelineAltBackground();
            }
        );

    },
    selectPostType: function() {
        if ($("select[name='custom_post_type']").val() == 'product') {
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == 'wp_timeline_productsetting') {
                        $(this).removeClass('clickDisable')
                    }
                    if (hide == 'wp_timeline_eddsetting') {
                        $(this).addClass('clickDisable')
                    }
                    $('.wtl-post-category,.wtl-post-tag-settings').hide();
                }
            );
        } else if ($("select[name='custom_post_type']").val() == 'download') {
            $(".wp-timeline-post-sticky").hide();
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == 'wp_timeline_eddsetting') {
                        $(this).removeClass('clickDisable');
                    }
                    if (hide == 'wp_timeline_productsetting') {
                        $(this).addClass('clickDisable');
                    }
                }
            );
        } else {
            if ($("select[name='custom_post_type']").val() == 'post') {
                $('.wp-timeline-setting-handle li').each(
                    function() {
                        var hide = $(this).attr('data-show');
                        if (hide == 'wp_timeline_productsetting') {
                            $(this).addClass('clickDisable');
                        }
                        if (hide == 'wp_timeline_eddsetting') {
                            $(this).addClass('clickDisable');
                        }
                    }
                );
            } else {
                $(".wtl-post-category").hide();
                $(".post-tag").hide();
                $('.advance_filter_option').hide();
                $("#advance_filter_0").prop("checked", true);
                $("#advance_filter_1").prop("checked", false);
            }
        }
        $("select[name='custom_post_type']").on(
            'change',
            function() {
                var posttypeval = $(this).val();
                if (posttypeval == 'product') {
                    $('.wp-timeline-setting-handle li').each(
                        function() {
                            var hide = $(this).attr('data-show');
                            if (hide == 'wp_timeline_productsetting') {
                                $(this).removeClass('clickDisable');
                            }
                            if (hide == 'wp_timeline_eddsetting') {
                                $(this).addClass('clickDisable');
                            }
                        }
                    );
                } else if (posttypeval == 'download') {
                    $(".wp-timeline-post-sticky").hide();
                    $('.wp-timeline-setting-handle li').each(
                        function() {
                            var hide = $(this).attr('data-show');
                            if (hide == 'wp_timeline_eddsetting') {
                                $(this).removeClass('clickDisable');
                            }
                            if (hide == 'wp_timeline_productsetting') {
                                $(this).addClass('clickDisable');
                            }
                        }
                    );
                } else {
                    $('.wp-timeline-setting-handle li').each(
                        function() {
                            var hide = $(this).attr('data-show');
                            if (hide == 'wp_timeline_productsetting') {
                                $(this).addClass('clickDisable');
                            }
                            if (hide == 'wp_timeline_eddsetting') {
                                $(this).addClass('clickDisable');
                            }
                        }
                    );
                }
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: { action: 'wtl_get_acf_field_list', posttype: posttypeval },
                    success: function(response) {
                        $('.wp_timeline_setting_acf_field_blog').html('');
                        $('.wp_timeline_setting_acf_field_blog').html(response);
                        $(".chosen-select").chosen();
                    }
                });
                $("#wp_timeline_general .wp-timeline-display-settings .display-custom-taxonomy").remove();
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: { action: 'wtl_custom_post_taxonomy_display_settings', posttype: posttypeval },
                    success: function(response) {
                        console.log(response);
                        var gndist = '#wp_timeline_general .wp-timeline-display-settings';
                        $(gndist + " .display-custom-taxonomy").remove();
                        $(gndist + ' .wp-timeline-typography-wrapper').prepend(response);
                        if (response == "") {
                            $(gndist + " .display-custom-taxonomy").remove();
                        }
                        $('.buttonset').buttonset();
                    }
                });
                if (posttypeval == 'post') {
                    $(".wtl-post-category").show();
                    $(".post-tag").show();
                    $(".advance_filter_settings").show();
                    if ($("input[name='advance_filter']:checked").val() == 1) {
                        $('.advance_filter_option').show();
                    } else {
                        $('.advance_filter_option').hide();
                    }
                    $(".wp-timeline-post-terms").remove();
                } else {
                    $(".wtl-post-category").hide();
                    $(".post-tag").hide();
                    $('.advance_filter_option').hide();
                    $("#advance_filter_0").prop("checked", true);
                    $("#advance_filter_1").prop("checked", false);
                }
                wtladmin.wp_timelineAltBackground();
            }
        );
    },
    paginationTypeSelection: function() {
        if ($("select[name='pagination_type']").val() == 'paged') {
            $(".wp_template_pagination_template").show();
            $('.loadmore_btn_option').hide();

        } else {
            $(".wp_template_pagination_template").hide();
            $('.loadmore_btn_option').hide();
            $(".default_loader").hide();
            $(".upload_loader").hide();
            $(".wp_template_loader_template").hide();
        }
        if ($("select[name='pagination_type']").val() == 'load_more_btn' || $("select[name='pagination_type']").val() == 'load_onscroll_btn') {
            $(".wp_template_loader_template").show();
            if ($("select[name='pagination_type']").val() == 'load_more_btn') {
                $('.loadmore_btn_option').show();
            } else {
                $('.loadmore_btn_option').hide();
            }
            if ($("select[name='loader_type']").val() != 1) {
                $(".default_loader").show();
                $(".upload_loader").hide();
            } else if ($("select[name='pagination_type']").val() == 'load_more_btn' || $("select[name='pagination_type']").val() == 'load_onscroll_btn') {
                $(".default_loader").hide();
                $(".upload_loader").show();
            }
        } else {
            $(".wp_template_loader_template").hide();
        }
    },
    disable_link_chk: function() {
        var tycnt = 'div.wp-timeline-typography-content',
            indcat = "input[name='display_category']",
            indtag = "input[name='display_tag']",
            indaut = "input[name='display_author']",
            indcct = "input[name='display_comment_count']";
            inddt = "input[name='display_date']";

        // Categories link option
        if ($(indcat + ":checked").val() == 1) {
            $(indcat).closest(tycnt).find('.disable_link').show()
        } else {
            $(indcat).closest(tycnt).find('.disable_link').hide()
        }
        $(indcat).on(
            'change',
            function() {
                if ($(indcat + ":checked").val() == 1) {
                    $(indcat).closest(tycnt).find('.disable_link').show()
                } else {
                    $(indcat).closest(tycnt).find('.disable_link').hide()
                }
            }
        );

        // Tags link option
        if ($("input[name='display_tag']:checked").val() == 1) {
            $("input[name='display_tag']").closest(tycnt).find('.disable_link').show()
        } else {
            $("input[name='display_tag']").closest(tycnt).find('.disable_link').hide()
        }

        $(indtag).on(
            'change',
            function() {
                if ($(indtag + ":checked").val() == 1) {
                    $(indtag).closest(tycnt).find('.disable_link').show()
                } else {
                    $(indtag).closest(tycnt).find('.disable_link').hide()
                }
            }
        );
        // Author link option
        if ($("input[name='display_author']:checked").val() == 1) {
            $("input[name='display_author']").closest(tycnt).find('.disable_link').show()
        } else {
            $("input[name='display_author']").closest(tycnt).find('.disable_link').hide()
        }

        $(indaut).on(
            'change',
            function() {
                if ($(indaut + ":checked").val() == 1) {
                    $(indaut).closest(tycnt).find('.disable_link').show()
                } else {
                    $(indaut).closest(tycnt).find('.disable_link').hide()
                }
            }
        );

        if ($("#custom_post_type").val() == 'product' || $("#custom_post_type").val() == 'download') {
            $("input[name='display_author']").closest(tycnt).find('.disable_link').hide();
        }
        // Publish Date link option
        if ($("input[name='display_date']:checked").val() == 1) {
            $("input[name='display_date']").closest(tycnt).find('.disable_link').show();
        } else {
            $("input[name='display_date']").closest(tycnt).find('.disable_link').hide();
        }
        // Comment Form link option
        if ($("input[name='display_comment_count']:checked").val() == 1 || $("input[name='display_comment']:checked").val() == 1) {
            $("input[name='display_comment_count']").closest(tycnt).find('.disable_link').show();
            $("input[name='display_comment']").closest(tycnt).find('.disable_link').show();
        } else {
            $("input[name='display_comment_count']").closest(tycnt).find('.disable_link').hide();
            $("input[name='display_comment']").closest(tycnt).find('.disable_link').hide();
        }
        $(indcct).on(
            'change',
            function() {
                if ($(indcct + ":checked").val() == 1) {
                    $(indcct).closest(tycnt).find('.disable_link').show()
                } else {
                    $(indcct).closest(tycnt).find('.disable_link').hide()
                }
            }
        );
        $(inddt).on(
            'change',
            function() {
                if ($(inddt + ":checked").val() == 1) {
                    $(inddt).closest(tycnt).find('.disable_link').show()
                } else {
                    $(inddt).closest(tycnt).find('.disable_link').hide()
                }
            }
        );
        // Taxonomy Set
        $("fieldset.taxonomies_set input").each(
            function() {
                var name = $(this).attr("name");
                if ($("input[name='" + name + "']:checked").val() == 1) {
                    $(this).closest(tycnt).find('.disable_link').show();
                } else {
                    $(this).closest(tycnt).find('.disable_link').hide();
                }
            }
        );
        $("fieldset.wp-timeline-display_tax input").each(
            function() {
                var name = $(this).attr("name");
                if ($("input[name='" + name + "']:checked").val() == 1) {
                    $(this).closest(tycnt).find('.disable_link').show();
                } else {
                    $(this).closest(tycnt).find('.disable_link').hide();
                }
            }
        );
    },
    wp_timelineAltBackground: function() {
        /*Alternet background color set*/
        $('.postbox').each(
            function() {
                var li = 'ul.wp-timeline-settings > li';
                $(this).find(li).removeClass('wp-timeline-gray');
                $(this).find(li + ':visible:odd').addClass('wp-timeline-gray')
            }
        );
    },
    blogTemplateSearch: function(tmpnm) {
        var tpnm = $('.wp_timeline_template_name').val()
        var altmphide = true;
        if (tmpnm.length < 3) {
            tmpnm = ''
        };
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: { action: 'wtl_template_search_result', temlate_name: tmpnm, _wpnonce: wp_timeline_js._wpnonce },
            success: function(response) {
                $('.wp-timeline-blog-template-cover').html(response);
                $('.template-thumbnail').show();
                $('.template-thumbnail').each(
                    function() {
                        if ($(this).is(':visible')) {
                            altmphide = false;
                        }
                    }
                );
                if (altmphide) {
                    $('.no-template').show();
                } else {
                    $('.no-template').hide();
                }
                $("#popupdiv div.template-thumbnail .popup-select a").on(
                    'click',
                    function(e) {
                        e.preventDefault();
                        $('#popupdiv div.template-thumbnail').removeClass('wp_timeline_selected_template');
                        $(this).parents('div.template-thumbnail').addClass('wp_timeline_selected_template');
                    }
                );
                $('#popupdiv .template-thumbnail').removeClass('wp_timeline_selected_template');
                $('#popupdiv .template-thumbnail').each(
                    function() {
                        if ($(this).children('.template-thumbnail-inner').children('img').attr('data-value') == tpnm) {
                            $(this).addClass('wp_timeline_selected_template');
                        }
                    }
                );
                $('.wp-timeline-blog-template-cover .template-thumbnail').each(
                    function() {
                        var templateLable = $(this).data('value');
                        if (templateLable != '' && templateLable != undefined) {
                            $(this).append('<div class="wp-timeline-label">' + templateLable + '</div>')
                        }
                    }
                );
            }
        });
    },

    reset_layout_to_default: function() {
        page_display = $('#wtl_page_display').val()
        layout = this.current_layout();
        lid = $('.wp-timeline-shortcode-div').attr('lid');
        $.ajax({
            type: 'POST',
            dataType: 'text',
            crossDomain: true,
            cache: false,
            url: ajaxurl,
            data: { 'action': 'wtl_do_rest_layout_ajax', layout: layout, page_display: page_display, lid: lid },
            success: function(data) {
                wtl_settings = JSON.parse(data);
                wtladmin.do_reset(wtl_settings);
                if (data == 'reset_done') {
                    wtladmin.do_reset(wtl_settings);
                    // location.reload();
                }
            }
        });

        $("#social_share_0,#read_more_link_0").prop("checked", true);
        $("#social_share_0,#read_more_link_0").attr('checked', 'checked');
        $("#date_font_family").val('Roboto');
        if (this.current_layout() == 'advanced_layout') {
            $('#content_box_bg_color').val('#f1f1f1');
            $('#wp_timeline_content_border_radius').val('5');
            $('#template_contentcolor').val('#333');
            $('#content_fontsize').val('16');
            $("#display_date_1").attr('checked', 'checked');
            $('#template_color').val('#000');

            $("#display_category_0").attr('checked', 'checked');
            $("#display_tag_0").attr('checked', 'checked');
            $("#display_author_1").attr('checked', 'checked');
            $("#display_date_1").attr('checked', 'checked');
            $("#display_comment_count_0").attr('checked', 'checked');

            $('#template_titlecolor').val('#fff');
            $('#template_titlehovercolor').val('#f1f1f1');
            $('#template_titlebackcolor').val('');
            $('#template_titlefontsize').val('20');
            $('#wp_timeline_lazy_load_image_0').attr('checked', 'checked');

        }
        if (this.current_layout() == 'hire_layout') {
            $('#timeline_heading_1').val('New hire timeline');
            $('#timeline_heading_2').val('Your first day');

            $("#display_category_1").attr('checked', 'checked');
            $("#display_tag_1").attr('checked', 'checked');
            $("#display_author_1").attr('checked', 'checked');
            $("#display_date_1").attr('checked', 'checked');

            // Standard Settings

            $('#template_bgcolor').val('#fff');
            $('#meta_fontsize,#content_fontsize').val('18');
            // Post Title
            $('#template_titlecolor').val('#2e3e4b');
            $('#template_titlehovercolor').val('#2e3e4b');
            $('#template_titlebackcolor').val('');
            $('#template_titlefontsize').val('24');

            $("#template_title_alignment_center").attr('checked', 'checked');
            $('#template_title_font_text_transform option[value="uppercase"]').attr('selected', 'selected');
            $('#template_title_font_weight option[value="700"]').attr('selected', 'selected');

            // Post Content
            $('#template_contentcolor').val('#57616b');
            $('#content_box_bg_color').val('#fff');
            $('#meta_fontsize,#content_fontsize').val('18');
            $('#content_font_family option[value="Georgia, serif"]').attr('selected', 'selected');
            // Timeline
            $('#template_color').val('#313d4b');
            $('#wp_timeline_lazy_load_image_0').attr('checked', 'checked');
        }
        if (this.current_layout() == 'curve_layout') {
            $("#display_category_1").attr('checked', 'checked');
            $("#display_tag_1").attr('checked', 'checked');
            $("#display_author_1").attr('checked', 'checked');
            // Standard Settings
            $('#template_bgcolor').val('#fff');
            // Post Title
            $('#template_titlecolor').val('#2d3033');
            $('#template_titlehovercolor').val('#2d3033');
            $('#template_titlebackcolor').val('');
            $('#template_titlefontsize').val('22');
            $('#template_titlefontface option[value="Georgia, serif"]').attr('selected', 'selected');
            $('#template_title_font_weight option[value="600"]').attr('selected', 'selected');

            // Content box
            $('#content_box_bg_color').val('');
            $('#template_contentcolor').val('#2d3033');
            $('#meta_fontsize,#content_fontsize').val('18');
            $('#content_font_family option[value="Georgia, serif"]').attr('selected', 'selected');

            // Timeline
            $('#template_color').val('#2d3033');
            $('#template_color2').val('#2d3033');
            $('#template_color3').val('#338754');
            $('#template_color4').val('#338754');
            $('#template_color5').val('#2d3033');
            // social
            $("#social_share_1").attr('checked', 'checked');
            $("#default_icon_theme_9").attr('checked', 'checked');
            $('#facebook_link_with_count').prop('checked', true);
            $('#pinterest_link_with_count').prop('checked', true);
            $('#wp_timeline_lazy_load_image_0').attr('checked', 'checked');
        }
        if (this.current_layout() == 'fullwidth_layout') {
            $('#timeline_heading_1').val('7 Things to Do');
            $('#timeline_heading_2').val("Before A New Hires First Day");

            // Post Title
            $('#template_titlecolor').val('#fff');
            $('#template_titlehovercolor').val('');
            $('#template_titlebackcolor').val('');
            $("#template_title_alignment_center").attr('checked', 'checked');
            $('#template_titlefontsize').val('24');
            $('#template_titlefontface option[value="Georgia, serif"]').attr('selected', 'selected');
            // Content
            $('#template_contentcolor').val('#fff');
            $('#content_box_bg_color').val('');
            $('#meta_fontsize,#content_fontsize').val('20');
            $('#content_font_family option[value="Georgia, serif"]').attr('selected', 'selected');
            // box
            $('#content_box_bg_color').val('');
            $('#wp_timeline_lazy_load_image_0').attr('checked', 'checked');
        }
        if (this.current_layout() == 'easy_layout') {
            $("#display_category_0").attr('checked', 'checked');
            $("#display_tag_0").attr('checked', 'checked');
            $("#display_author_1").attr('checked', 'checked');
            $("#display_date_1").attr('checked', 'checked');
            $("#display_comment_count_0").attr('checked', 'checked');
            
            // Post Title
            $('#template_titlecolor').val('#000');
            $('#template_titlehovercolor').val('#23be63');
            $('#template_titlebackcolor').val('');
            $('#template_titlefontsize').val('18');
            $('#template_titlefontface option[value="Arial, Helvetica, sans-serif"]').attr('selected', 'selected');
            // Post Content
            $('#template_contentcolor').val('#000');
            $('#meta_fontsize,#content_fontsize').val('18');
            $('#content_font_family option[value="Arial, Helvetica, sans-serif"]').attr('selected', 'selected');

            // media
            $("#wp_timeline_enable_media_0").attr('checked', 'checked');
            $("#read_more_link_1").attr('checked', 'checked');
            // box
            $('#wp_timeline_content_border_radius').val('3');
            $('#wp_timeline_top_content_box_shadow').val('1');
            $('#wp_timeline_right_content_box_shadow').val('1');
            $('#wp_timeline_bottom_content_box_shadow').val('4');
            $('#wp_timeline_left_content_box_shadow').val('1');
            $('#wp_timeline_content_box_shadow_color').val('#bfbfbf');
            $('#wp_timeline_lazy_load_image_0').attr('checked', 'checked');

        }
    },
    reset_layout_when_new: function() {
        layout = this.current_layout();
        $.ajax({
            type: 'POST',
            dataType: 'text',
            crossDomain: true,
            cache: false,
            url: ajaxurl,
            data: { 'action': 'wtl_load_default_layout_ajax', layout: layout },
            success: function(data) {
                wtl_settings = JSON.parse(data);
                wtladmin.do_reset(wtl_settings);
            }
        });
    },
    do_reset: function(wtl_settings) {
        /* General Settings */
        $('#timeline_heading_1').val(wtl_settings['timeline_heading_1']);
        $('#timeline_heading_2').val(wtl_settings['timeline_heading_2']);
        $('#posts_per_page').val(wtl_settings['posts_per_page']); // posts_per_page

        if (wtl_settings['display_category']) {
            $("#display_category_1").attr('checked', 'checked')
        } else {
            $("#display_category_0").attr('checked', 'checked')
        }
        if (wtl_settings['display_tag']) {
            $("#display_tag_1").attr('checked', 'checked')
        } else {
            $("#display_tag_0").attr('checked', 'checked')
        }
        if (wtl_settings['display_author']) {
            $("#display_author_1").attr('checked', 'checked')
        } else {
            $("#display_author_0").attr('checked', 'checked')
        }
        if (wtl_settings['display_date']) {
            $("#display_date_1").attr('checked', 'checked')
        } else {
            $("#display_date_0").attr('checked', 'checked')
        }
        if (wtl_settings['display_comment_count']) {
            $("#display_comment_count_1").attr('checked', 'checked')
        } else {
            $("#display_comment_count_0").attr('checked', 'checked')
        }

        // display_story_year
        $('#custom_css').val(wtl_settings['custom_css']);

        /* Standard Settings */
        $('#template_bgcolor').val(wtl_settings['template_bgcolor']);
        $('#wp_timeline_post_offset').val(wtl_settings['wp_timeline_post_offset']);

        $('#meta_font_family_font_type option[value="' + wtl_settings["meta_font_family_font_type"] + '"]').attr('selected', 'selected');
        $('#meta_font_family option[value="' + wtl_settings["meta_font_family"] + '"]').attr('selected', 'selected');
        $('#meta_fontsize').val(wtl_settings['meta_fontsize']);
        $('#meta_font_weight option[value="' + wtl_settings["meta_font_weight"] + '"]').attr('selected', 'selected');
        $('#meta_font_line_height').val(wtl_settings['meta_font_line_height']);
        if (wtl_settings['meta_font_italic']) {
            $("#meta_font_italic_1").attr('checked', 'checked')
        } else {
            $("#meta_font_italic_0").attr('checked', 'checked')
        }
        $('#meta_font_text_transform option[value="' + wtl_settings["meta_font_text_transform"] + '"]').attr('selected', 'selected');
        $('#meta_font_text_decoration option[value="' + wtl_settings["meta_font_text_decoration"] + '"]').attr('selected', 'selected');
        $('#meta_font_letter_spacing').val(wtl_settings['meta_font_letter_spacing']);

        $('#date_font_family_font_type option[value="' + wtl_settings["date_font_family_font_type"] + '"]').attr('selected', 'selected');
        $('#date_font_family option[value="' + wtl_settings["date_font_family"] + '"]').attr('selected', 'selected');
        $('#date_fontsize').val(wtl_settings['date_fontsize']);
        $('#date_font_weight option[value="' + wtl_settings["date_font_weight"] + '"]').attr('selected', 'selected');
        $('#date_font_line_height').val(wtl_settings['date_font_line_height']);
        if (wtl_settings['date_font_italic']) {
            $("#date_font_italic_1").attr('checked', 'checked')
        } else {
            $("#date_font_italic_0").attr('checked', 'checked')
        }
        $('#date_font_text_transform option[value="' + wtl_settings["date_font_text_transform"] + '"]').attr('selected', 'selected');
        $('#date_font_text_decoration option[value="' + wtl_settings["date_font_text_decoration"] + '"]').attr('selected', 'selected');
        $('#date_font_letter_spacing').val(wtl_settings['date_font_letter_spacing']);

        /* Post Title Settings */
        if (wtl_settings['wp_timeline_post_title_link']) {
            $("#wp_timeline_post_title_link_1").attr('checked', 'checked')
        } else {
            $("#wp_timeline_post_title_link_0").attr('checked', 'checked')
        }
        if (wtl_settings['template_title_alignment'] == 'center') {
            $("#template_title_alignment_center").attr('checked', 'checked')
        } else if (wtl_settings['template_title_alignment'] == 'right') {
            $("#template_title_alignment_right").attr('checked', 'checked')
        } else {
            $("#template_title_alignment_left").attr('checked', 'checked')
        }
        $('#template_titlecolor').val(wtl_settings['template_titlecolor']);
        $('#template_titlehovercolor').val(wtl_settings['template_titlehovercolor']);
        $('#template_titlebackcolor').val(wtl_settings['template_titlebackcolor']);

        /* Post Content Settings */
        if (wtl_settings['rss_use_excerpt'] == '0') {
            $("#rss_use_excerpt_0").attr('checked', 'checked')
        } else {
            $("#rss_use_excerpt_1").attr('checked', 'checked')
        }
        $('#template_post_content_from option[value="' + wtl_settings["template_post_content_from"] + '"]').attr('selected', 'selected');
        if (wtl_settings['display_html_tags'] == '1') {
            $("#display_html_tags_1").attr('checked', 'checked')
        } else {
            $("#display_html_tags_0").attr('checked', 'checked')
        }
        if (wtl_settings['firstletter_big'] == '1') {
            $("#firstletter_big_1").attr('checked', 'checked')
        } else {
            $("#firstletter_big_0").attr('checked', 'checked')
        }

        $('#firstletter_font_family option[value="' + wtl_settings["firstletter_font_family"] + '"]').attr('selected', 'selected');
        $('#firstletter_fontsize').val(wtl_settings['firstletter_fontsize']);
        $('#firstletter_contentcolor').val(wtl_settings['firstletter_contentcolor']);
        $('#txtExcerptlength').val(wtl_settings['txtExcerptlength']);

        if (wtl_settings['advance_contents'] == '1') {
            $("#advance_contents_1").attr('checked', 'checked')
        } else {
            $("#advance_contents_0").attr('checked', 'checked')
        }
        $('#contents_stopage_from option[value="' + wtl_settings["contents_stopage_from"] + '"]').attr('selected', 'selected');
        // contents_stopage_character

        $('#template_contentcolor').val(wtl_settings['template_contentcolor']);

        $('#content_font_family_font_type option[value="' + wtl_settings["content_font_family_font_type"] + '"]').attr('selected', 'selected');
        $('#content_font_family option[value="' + wtl_settings["content_font_family"] + '"]').attr('selected', 'selected');
        $('#content_fontsize').val(wtl_settings['content_fontsize']);
        $('#content_font_weight option[value="' + wtl_settings["content_font_weight"] + '"]').attr('selected', 'selected');
        $('#content_font_line_height').val(wtl_settings['content_font_line_height']);
        if (wtl_settings['content_font_italic']) {
            $("#content_font_italic_1").attr('checked', 'checked')
        } else {
            $("#content_font_italic_0").attr('checked', 'checked')
        }
        $('#content_font_text_transform option[value="' + wtl_settings["content_font_text_transform"] + '"]').attr('selected', 'selected');
        $('#content_font_text_decoration option[value="' + wtl_settings["content_font_text_decoration"] + '"]').attr('selected', 'selected');
        $('#content_font_letter_spacing').val(wtl_settings['content_font_letter_spacing']);
        // Read More
        if (wtl_settings['read_more_link'] == '1') {
            $("#read_more_link_1").attr('checked', 'checked')
        } else {
            $("#read_more_link_0").attr('checked', 'checked')
        }
        if (wtl_settings['read_more_on'] == '1') {
            $("#read_more_on_1").attr('checked', 'checked')
        } else {
            $("#read_more_on_0").attr('checked', 'checked')
        }
        $('#txtReadmoretext').val(wtl_settings['txtReadmoretext']);

        if (wtl_settings['post_link_type'] == '0') {
            $("#post_link_type_0").attr('checked', 'checked')
        } else {
            $("#post_link_type_1").attr('checked', 'checked')
        }
        $('#custom_link_url').val(wtl_settings['custom_link_url']);

        if (wtl_settings['readmore_button_alignment'] == 'center') {
            $("#readmore_button_alignment_center").attr('checked', 'checked')
        } else if (wtl_settings['readmore_button_alignment'] == 'right') {
            $("#readmore_button_alignment_right").attr('checked', 'checked')
        } else {
            $("#readmore_button_alignment_left").attr('checked', 'checked')
        }
        $('#template_readmorecolor').val(wtl_settings['template_readmorecolor']);
        $('#template_readmorehovercolor').val(wtl_settings['template_readmorehovercolor']);
        $('#template_readmorebackcolor').val(wtl_settings['template_readmorebackcolor']);
        $('#template_readmore_hover_backcolor').val(wtl_settings['template_readmore_hover_backcolor']);

        $('#read_more_button_border_style option[value="' + wtl_settings["read_more_button_border_style"] + '"]').attr('selected', 'selected');
        $('#readmore_button_border_radius').val(wtl_settings['readmore_button_border_radius']);
        $('#wp_timeline_readmore_button_borderleft').val(wtl_settings['wp_timeline_readmore_button_borderleft']);
        $('#wp_timeline_readmore_button_borderleftcolor').val(wtl_settings['wp_timeline_readmore_button_borderleftcolor']);
        $('#wp_timeline_readmore_button_borderright').val(wtl_settings['wp_timeline_readmore_button_borderright']);
        $('#wp_timeline_readmore_button_borderrightcolor').val(wtl_settings['wp_timeline_readmore_button_borderrightcolor']);
        $('#wp_timeline_readmore_button_bordertop').val(wtl_settings['wp_timeline_readmore_button_bordertop']);
        $('#wp_timeline_readmore_button_bordertopcolor').val(wtl_settings['wp_timeline_readmore_button_bordertopcolor']);
        $('#wp_timeline_readmore_button_borderbottom').val(wtl_settings['wp_timeline_readmore_button_borderbottom']);
        $('#wp_timeline_readmore_button_borderbottomcolor').val(wtl_settings['wp_timeline_readmore_button_borderbottomcolor']);
        $('#readmore_button_border_radius').val(wtl_settings['readmore_button_border_radius']);
        $('#readmore_button_border_radius').val(wtl_settings['readmore_button_border_radius']);

        $('#read_more_button_hover_border_style option[value="' + wtl_settings["read_more_button_hover_border_style"] + '"]').attr('selected', 'selected');

        $('#readmore_button_hover_border_radius').val(wtl_settings['readmore_button_hover_border_radius']);
        $('#wp_timeline_readmore_button_hover_borderleft').val(wtl_settings['wp_timeline_readmore_button_hover_borderleft']);
        $('#wp_timeline_readmore_button_hover_borderleftcolor').val(wtl_settings['wp_timeline_readmore_button_hover_borderleftcolor']);
        $('#wp_timeline_readmore_button_hover_borderright').val(wtl_settings['wp_timeline_readmore_button_hover_borderright']);
        $('#wp_timeline_readmore_button_hover_borderrightcolor').val(wtl_settings['wp_timeline_readmore_button_hover_borderrightcolor']);
        $('#wp_timeline_readmore_button_hover_bordertop').val(wtl_settings['wp_timeline_readmore_button_hover_bordertop']);
        $('#wp_timeline_readmore_button_hover_bordertopcolor').val(wtl_settings['wp_timeline_readmore_button_hover_bordertopcolor']);
        $('#wp_timeline_readmore_button_hover_borderbottom').val(wtl_settings['wp_timeline_readmore_button_hover_borderbottom']);
        $('#wp_timeline_readmore_button_hover_borderbottomcolor').val(wtl_settings['wp_timeline_readmore_button_hover_borderbottomcolor']);

        $('#readmore_button_paddingleft').val(wtl_settings['readmore_button_paddingleft']);
        $('#readmore_button_paddingright').val(wtl_settings['readmore_button_paddingright']);
        $('#readmore_button_paddingtop').val(wtl_settings['readmore_button_paddingtop']);
        $('#readmore_button_paddingbottom').val(wtl_settings['readmore_button_paddingbottom']);

        $('#readmore_button_marginleft').val(wtl_settings['readmore_button_marginleft']);
        $('#readmore_button_marginright').val(wtl_settings['readmore_button_marginright']);
        $('#readmore_button_margintop').val(wtl_settings['readmore_button_margintop']);
        $('#readmore_button_marginbottom').val(wtl_settings['readmore_button_marginbottom']);

        $('#readmore_font_family_font_type option[value="' + wtl_settings["readmore_font_family_font_type"] + '"]').attr('selected', 'selected');
        $('#readmore_font_family option[value="' + wtl_settings["readmore_font_family"] + '"]').attr('selected', 'selected');
        $('#readmore_fontsize').val(wtl_settings['readmore_fontsize']);
        $('#readmore_font_weight option[value="' + wtl_settings["readmore_font_weight"] + '"]').attr('selected', 'selected');
        $('#readmore_font_line_height').val(wtl_settings['readmore_font_line_height']);
        if (wtl_settings['readmore_font_italic']) {
            $("#readmore_font_italic_1").attr('checked', 'checked')
        } else {
            $("#readmore_font_italic_0").attr('checked', 'checked')
        }
        $('#readmore_font_text_transform option[value="' + wtl_settings["readmore_font_text_transform"] + '"]').attr('selected', 'selected');
        $('#readmore_font_text_decoration option[value="' + wtl_settings["readmore_font_text_decoration"] + '"]').attr('selected', 'selected');
        $('#readmore_font_letter_spacing').val(wtl_settings['readmore_font_letter_spacing']);

        /* Content Box Settings */
        $('#wp_timeline_content_border_width').val(wtl_settings['wp_timeline_content_border_width']);
        $('#wp_timeline_content_border_style option[value="' + wtl_settings["wp_timeline_content_border_style"] + '"]').attr('selected', 'selected');
        $('#wp_timeline_content_border_color').val(wtl_settings['wp_timeline_content_border_color']);
        $('#wp_timeline_content_border_radius').val(wtl_settings['wp_timeline_content_border_radius']);

        $('#content_box_bg_color').val(wtl_settings['content_box_bg_color']);
        $('#content_box_bg_color').val(wtl_settings['content_box_bg_color']);
        $('#wp_timeline_top_content_box_shadow').val(wtl_settings['wp_timeline_top_content_box_shadow']);
        $('#wp_timeline_right_content_box_shadow').val(wtl_settings['wp_timeline_right_content_box_shadow']);
        $('#wp_timeline_bottom_content_box_shadow').val(wtl_settings['wp_timeline_bottom_content_box_shadow']);
        $('#wp_timeline_left_content_box_shadow').val(wtl_settings['wp_timeline_left_content_box_shadow']);
        $('#wp_timeline_content_box_shadow_color').val(wtl_settings['wp_timeline_content_box_shadow_color']);
        $('#wp_timeline_content_padding_leftright').val(wtl_settings['wp_timeline_content_padding_leftright']);
        $('#wp_timeline_content_padding_topbottom').val(wtl_settings['wp_timeline_content_padding_topbottom']);

        /* Timeline Settings */
        $('#timeline_animation option[value="' + wtl_settings["timeline_animation"] + '"]').attr('selected', 'selected');
        $('#template_color').val(wtl_settings['template_color']);
        $('#template_color2').val(wtl_settings['template_color2']);
        $('#template_color3').val(wtl_settings['template_color3']);
        $('#template_color4').val(wtl_settings['template_color4']);
        $('#template_color5').val(wtl_settings['template_color5']);
        $('#story_startup_text').val(wtl_settings['story_startup_text']);
        $('#story_ending_text').val(wtl_settings['story_ending_text']);
        $('#story_start_bg_color').val(wtl_settings['story_start_bg_color']);
        $('#story_start_text_color').val(wtl_settings['story_start_text_color']);
        $('#story_ending_bg_color').val(wtl_settings['story_ending_bg_color']);
        $('#story_ending_text_color').val(wtl_settings['story_ending_text_color']);

        $('#wtl_single_display_timeline_icon').val(wtl_settings['wtl_single_display_timeline_icon']);
        $('#wtl_single_timeline_icon').val(wtl_settings['wtl_single_timeline_icon']);
        $('#wtl_icon_image_id').val(wtl_settings['wtl_icon_image_id']);
        $('#wtl_icon_image_src').val(wtl_settings['wtl_icon_image_src']);

        if (wtl_settings['layout_type'] == '1') {
            $("#layout_type_1").attr('checked', 'checked')
        } else {
            $("#layout_type_2").attr('checked', 'checked')
        }
        /* Media Settings */
        if (wtl_settings['wp_timeline_enable_media'] == '1') {
            $("#wp_timeline_enable_media_1").attr('checked', 'checked')
        } else {
            $("#wp_timeline_enable_media_0").attr('checked', 'checked')
        }

        if (wtl_settings['wp_timeline_post_image_link'] == '1') {
            $("#wp_timeline_post_image_link_1").attr('checked', 'checked')
        } else {
            $("#wp_timeline_post_image_link_0").attr('checked', 'checked')
        }

        if (wtl_settings['wp_timeline_image_hover_effect'] == '1') {
            $("#wp_timeline_image_hover_effect_1").attr('checked', 'checked')
        } else {
            $("#wp_timeline_image_hover_effect_0").attr('checked', 'checked')
        }
        $('#wp_timeline_image_hover_effect_type option[value="' + wtl_settings["wp_timeline_image_hover_effect_type"] + '"]').attr('selected', 'selected');
        $('#wp_timeline_default_image_id').val(wtl_settings['wp_timeline_default_image_id']);
        $('#wp_timeline_default_image_src').val(wtl_settings['wp_timeline_default_image_src']);
        $('#wp_timeline_media_size option[value="' + wtl_settings["wp_timeline_media_size"] + '"]').attr('selected', 'selected');
        $('#media_custom_width').val(wtl_settings['media_custom_width']);
        $('#media_custom_height').val(wtl_settings['media_custom_height']);
        /* Horizontal Timeline Settings */

        if (wtl_settings['display_timeline_bar'] == '0') {
            $("#display_timeline_bar_0").attr('checked', 'checked')
        } else {
            $("#display_timeline_bar_1").attr('checked', 'checked')
        }
        $('#timeline_start_from').val(wtl_settings['timeline_start_from']);
        $('#media_custom_height').val(wtl_settings['media_custom_height']);
        $('#template_easing option[value="' + wtl_settings["template_easing"] + '"]').attr('selected', 'selected');
        $('#item_width').val(wtl_settings['item_width']);
        $('#item_height').val(wtl_settings['item_height']);
        $('#template_post_margin').val(wtl_settings['template_post_margin']);
        if (wtl_settings['enable_autoslide'] == '1') {
            $("#enable_autoslide_1").attr('checked', 'checked')
        } else {
            $("#enable_autoslide_0").attr('checked', 'checked')
        }
        $('#scroll_speed').val(wtl_settings['scroll_speed']);
        $('#noof_slider_nav_itme').val(wtl_settings['noof_slider_nav_itme']);
        $('#noof_slide').val(wtl_settings['noof_slide']);

        /* Filter Settings */
        /* Pagination Settings */
        $('#pagination_type option[value="' + wtl_settings["pagination_type"] + '"]').attr('selected', 'selected');

        /* Social Share Settings */
        if (wtl_settings['social_share'] == '1') {
            $("#social_share_1").attr('checked', 'checked')
        } else {
            $("#social_share_0").attr('checked', 'checked')
        }
    },
    hide_field_for_layout: function() {
        var cl = this.current_layout();
        ish = this.is_horizontal();
        if (ish) {
            $('.wp_timeline_pagination').addClass('clickDisable');
            $('.wtl_hz_ts_9,.wtl_hz_ts_10').show();
        } else {
            $('.wtl_hz_ts_9,.wtl_hz_ts_10').hide();
        }
        $('.hire-pbar-color').hide();
        $('.timeline_line_width').hide();
        icon_layout = $('.wtl_icon_layout_type');
        box_arrow_bor = $('.wtl_box_arrow_side_border');
        tl_style = $('.timeline_style');
        icon_layout.hide();
        box_arrow_bor.hide();
        tl_style.hide();

        if (cl == 'advanced_layout') {
            $('.titlebackcolor_tr,.temp-even-bg-color,.temp-odd-bg-color,.temp-even-color,.temp-odd-color,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl-post-timeline-icon,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6 ').hide();
            $('.wtl_heading_1,.wtl_heading_2').show()
            $('.timeline_line_width').show();
            icon_layout.show();
            box_arrow_bor.show();
            tl_style.show();
        }
        if (cl == 'hire_layout') {
            $('.timeline-icon-border-radious,.temp-even-bg-color,.temp-odd-bg-color,.temp-even-color,.temp-odd-color,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6 ').hide();
            $('.timeline_animation').show();
            $('.hire-pbar-color').show();
        }
        if (cl == 'curve_layout') {
            $('.wtl_heading_1,.wtl_heading_2,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl-post-timeline-icon,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6 ').hide();
            $('.wtl_heading_1,.wtl_heading_2').hide(); // ### HEADING ###
            $('.timeline_animation').show();
        }
        if (cl == 'fullwidth_layout') {
            $('.blog-templatebgcolor-tr, .wtl-post-timeline-icon, .timeline-icon-border-radious,.temp-even-bg-color,.temp-odd-bg-color,.temp-even-color,.temp-odd-color,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6,.wtl_hz_ts_9,.wtl_hz_ts_10 ').hide();
            $('.wtl-back-color-soft-block').show();
            $('.wp_timeline_settings').addClass('clickDisable');
            $('.timeline_animation').show();
        }
        if (cl == 'easy_layout') {
            $('.timeline-icon-border-radious,.temp-even-bg-color,.temp-odd-bg-color,.temp-even-color,.temp-odd-color,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6 ').hide();
            $('.wtl_heading_1,.wtl_heading_2').hide(); // ### HEADING ###
            $('.timeline_animation').show();
            $('.hide_timeline_icon_tr').show();
        } else {
            $('.hide_timeline_icon_tr').hide();
        }

        if (cl == 'soft_block') {
            $('.wtl-post-timeline-icon, .timeline-icon-border-radious,.temp-even-bg-color,.temp-odd-bg-color,.temp-even-color,.temp-odd-color,.story-s-text,.story-e-text,.story-s-bg-color,.story-s-text-color,.story-end-bg-color,.story-end-text-color,.wtl_hz_ts_2,.wtl_hz_ts_3,.wtl_hz_ts_4,.wtl_hz_ts_5,.wtl_hz_ts_6,.wtl_hz_ts_9,.wtl_hz_ts_10').hide();
            $('li[data-show="wp_timeline"]').addClass('clickDisable');
            $('li[data-show="wp_timeline_content_box"]').addClass('clickDisable');
            $('.wtl_heading_1,.wtl_heading_2').hide(); // ### HEADING ###
            $('.timeline_animation').show();
        }
        /*Mix*/
        if (cl == 'advanced_layout' || cl == 'hire_layout' || cl == 'curve_layout') {

            $('input[name="layout_type"]').on(
                'change',
                function() {
                    v = $('input[name="layout_type"]:checked').val();
                    if (v == 1) {
                        $('.wtl_hz_ts_9,.wtl_hz_ts_10').show();
                        $('.wp_timeline_pagination').addClass('clickDisable');
                    } else {
                        $('.wp_timeline_pagination').removeClass('clickDisable');
                    }
                }
            );

        }
        if (cl == 'advanced_layout' || cl == 'hire_layout' || cl == 'fullwidth_layout' || cl == 'soft_block') {
            $('.wtl_post_date_option').show();
        } else {
            $('.wtl_post_date_option').hide();
        }
    },
    blog_background_image: function() {
        tr = $('.blog_background_image_style_tr');
        if ($('#blog_background_image').is(':checked')) {
            tr.show()
        } else {
            tr.hide()
        }
    },
    read_more_inline: function() {
        rm_in_e = $('.read_more_button_alignment_setting,.read_more_text_background,.read_more_text_hover_background,.read_more_button_border_setting,.read_more_button_border_radius_setting,.read_more_button_border_setting,.read_more_button_border_setting,.read_more_button_border_radius_setting,.read_more_button_border_setting,.read_more_button_border_setting,.read_more_button_border_setting');
        if ($("input[name='read_more_on']:checked").val() == 1) {
            rm_in_e.hide();
        } else {
            rm_in_e.show();
        }
        $("input[name='read_more_on']").on(
            'change',
            function() {
                if ($(this).val() == 1) {
                    rm_in_e.hide();
                } else {
                    rm_in_e.show();
                }
            }
        );

    },
    wp_timelineCustomReadMore: function(dta) {
        $('.wp-timeline-setting-handle li').each(
            function() {
                var hd = $(this).attr('data-show');
                if (hd == 'wp_timeline_customreadmore') {
                    if (dta == 'show' && $('#pagination_type').val() == 'no_pagination') {
                        $(this).removeClass('clickDisable')
                    } else if (dta == 'hide') {
                        $(this).addClass('clickDisable')
                    }
                }
            }
        );
    },
    timeline_style_view: function() {
        var cl = this.current_layout();
        if (cl == 'advanced_layout') {
            tstyleview = $('.timeline_style_view');
            if ($("input[name='layout_type']:checked").val() == 1) {
                tstyleview.hide();
            } else {
                tstyleview.show()
            }
            $("input[name='layout_type']").on(
                'change',
                function() {
                    if ($(this).val() == 1) {
                        tstyleview.hide()
                    } else {
                        tstyleview.show()
                    }
                }
            );
        }
    },
    post_image_hover_effect() {
        var ihetr = $('.wp-timeline-image-hover-effect-tr');
        ihetr.hide();
        if ($("input[name='wp_timeline_enable_media']:checked").val() == 1 && $("input[name='wp_timeline_image_hover_effect']:checked").val() == 1) {
            ihetr.show()
        } else {
            ihetr.hide()
        };

        var mcstr = $('.wp_timeline_media_custom_size_tr');
        mcstr.hide();
        if ($('#wp_timeline_media_size').val() == 'custom') {
            mcstr.show();
        } else {
            mcstr.hide();
        }
        if ($('#pagination_type').val() != 'no_pagination') {
            var lmmbb = $('.load_more_btn_border');
            var lmbbs = $("select[name='load_more_button_border_style']");
            if (lmbbs.val() == 'none') {
                lmmbb.hide()
            } else {
                lmmbb.show()
            }
            lmbbs.on(
                'change',
                function() {
                    if ($(this).val() == 'none') {
                        lmmbb.hide()
                    } else {
                        lmmbb.show()
                    }
                }
            );
        }
    }

};
jQuery(document).ready(
    function() {
        (function($) {

            wtladmin.init();
            /** disanle link  */
            wtladmin.disable_link_chk();
            $('.buttonset').buttonset();

            /** Click on Save button  */
            $("#wp-timeline-btn-show-submit").on(
                'click',
                function() {
                    $(".bloglyout_savebtn").trigger("click")
                }
            );

            $(".wp-timeline-reset-data").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                
                $(".wp_timeline_loader").addClass("show");
                if (confirm("Are you sure you want to reset the layout?")) {
                    wtladmin.reset_layout_to_default();
                    setTimeout(function () {
                        $(".bloglyout_savebtn").trigger("click");
                        setTimeout(function () {
                            $(".wp_timeline_loader").removeClass("show");
                        }, 5000);
                    }, 5000);
                } else {
                    $(".wp_timeline_loader").removeClass("show");
                   
                }
            });
            
            /* Apply Chosen Script on select */
            $(".wp-timeline-settings-wrappers .wp-timeline-settings li select:not(.chosen-select)").wrap("<div class='select-cover'></div>");
            $(".chosen-select").chosen();
            $(".select-cover select").chosen({ no_results_text: "Oops, nothing found!" });
            wtladmin.template_search();
            wtladmin.setOptionVisibility($(".wp_timeline_template_name").val());
            /** Color preset change event  */
            wtladmin.controls_preset();
            /** Code mirror add on custom css */
            wtladmin.custom_css();
            /** Select layout  */
            wtladmin.setLayout();
            /** Click on setting tab */
            wtladmin.onTabClick();
            /** Font size apply slider */
            wtladmin.applySettings();
            /** Upload image */
            wtladmin.uploadImage();
            /** sort filter pagination  */
            wtladmin.sortFilterPageination();
            /** Select post type  */
            wtladmin.selectPostType();
            /** Post title maximum Line */
            wtladmin.title_maxlineSettings();
            /** Media Settings */
            wtladmin.mediaSettings();
            wtladmin.horizontalSetting();
            wtladmin.socialShare();
            wtladmin.read_more_inline();

            wptimelinejs.init();
            wtladmin.hide_field_for_layout();
            wtladmin.timeline_style_view();
            wtladmin.post_image_hover_effect();

            jQuery(document).on('click','.pro-feature, .pro-feature ul, .pro-feature input, .pro-feature a, .pro-feature button, .pro-feature div',
                function(e) {
                    e.preventDefault();
                    jQuery("#wtd-advertisement-popup").dialog({
                        resizable: false,
                        draggable: false,
                        modal: true,
                        height: "auto",
                        width: 'auto',
                        maxWidth: '100%',
                        dialogClass: 'wtd-advertisement-ui-dialog',
                        buttons: [{ text: 'X', "class": 'wtd-btn wtd-btn-gray', click: function() { jQuery(this).dialog("close") } }],
                        open: function(event, ui) {
                            jQuery(this).parent().children('.ui-dialog-titlebar').hide();
                        },
                        hide: { effect: "fadeOut", duration: 500 },
                        close: function(event, ui) {
                            jQuery('#wtd-template-search').val('');
                            jQuery("#wtd-advertisement-popup").dialog('close');
                        },
                    });
                }
            );

            jQuery('.ui-widget-overlay').on(
                "click",
                function() {
                    jQuery('#bd-template-search').val('');
                    jQuery("#wtd-advertisement-popup").dialog('close');
                }
            );
            jQuery('.wp_timeline_template_tab li a').on(
                'click',
                function(e) {
                    e.preventDefault();
                    var all_template_hide = true;
                    var href = jQuery(this).attr('href').replace('#', '');
                    jQuery('.template-thumbnail').hide();
                    if (href == 'all') {
                        jQuery(this).parent('li').addClass('c1');
                        jQuery('.wp_timeline_template_tab li').removeClass('c2');
                        jQuery('.template-thumbnail').show();
                    } else {
                        jQuery(this).parent('li').addClass('c2');
                        jQuery('.wp_timeline_template_tab li').removeClass('c1');
                        jQuery('.' + href + '.template-thumbnail').show();
                    }
                    jQuery('.template-thumbnail').each(
                        function() {
                            if (jQuery(this).is(':visible')) {
                                all_template_hide = false;
                            }
                        }
                    );
                    if (all_template_hide) {
                        jQuery('.no-template').show()
                    } else {
                        jQuery('.no-template').hide()
                    }
                }
            );
            jQuery('<div class="input-type-number-nav"><div class="input-type-number-button input-type-number-up">+</div><div class="input-type-number-button input-type-number-down">-</div></div>').insertAfter('.input-type-number input');
            jQuery('.input-type-number').each(
                function() {
                    var spinner = jQuery(this),
                        input = spinner.find('input[type="number"]'),
                        btnUp = spinner.find('.input-type-number-up'),
                        btnDown = spinner.find('.input-type-number-down'),
                        min = input.attr('min'),
                        max = input.attr('max');

                    btnUp.on( "click",
                        function() {
                            var oldValue = parseFloat(input.val());
                            if (oldValue >= max) {
                                var newVal = oldValue;
                            } else {
                                var newVal = oldValue + 1;
                            }
                            spinner.find("input").val(newVal);
                            spinner.find("input").trigger("change");
                        }
                    );

                    btnDown.on( "click",
                        function() {
                            var oldValue = parseFloat(input.val());
                            if (oldValue <= min) {
                                var newVal = oldValue;
                            } else {
                                var newVal = oldValue - 1;
                            }
                            spinner.find("input").val(newVal);
                            spinner.find("input").trigger("change");
                        }
                    );
                }
            );

        }(jQuery))
    }
);




var wptimelinejs = {
    init: function() {
        $ = jQuery;
        wptimelinejs.post_auto_slug();
    },
    post_auto_slug: function() {
        if ($('#cpt_icon_type_1').is(':checked')) {
            $('.wtl_cpt_icon_wordpress').show();
        }
        if ($('#cpt_icon_type_2').is(':checked')) {
            $('.wtl_cpt_icon_custom').show();
        }

        $('#cpt_icon_type_1, #cpt_icon_type_2').on(
            'change',
            function() {
                if ($('#cpt_icon_type_1').is(':checked')) {
                    $('.wtl_cpt_icon_wordpress').show();
                    $('.wtl_cpt_icon_custom').hide()
                }
                if ($('#cpt_icon_type_2').is(':checked')) {
                    $('.wtl_cpt_icon_custom').show();
                    $('.wtl_cpt_icon_wordpress').hide()
                }
            }
        );
        $('.li_cpt_category_name,.li_cpt_category_slug,.li_cpt_tag_name,.li_cpt_tag_slug').hide();

        if ($('#cpt_category_1').is(':checked')) {
            $('.li_cpt_category_name,.li_cpt_category_slug').show()
        }
        if ($('#cpt_category_0').is(':checked')) {
            $('.li_cpt_category_name,.li_cpt_category_slug').hide()
        }

        $('#cpt_category_1,#cpt_category_0').on(
            'change',
            function() {
                if ($('#cpt_category_1').is(':checked')) {
                    $('.li_cpt_category_name,.li_cpt_category_slug').show()
                }
                if ($('#cpt_category_0').is(':checked')) {
                    $('.li_cpt_category_name,.li_cpt_category_slug').hide()
                }
            }
        );

        if ($('#cpt_taxonomy_tag_1').is(':checked')) {
            $('.li_cpt_tag_name,.li_cpt_tag_slug').show()
        }
        if ($('#cpt_taxonomy_tag_0').is(':checked')) {
            $('.li_cpt_tag_name,.li_cpt_tag_slug').hide()
        }

        $('#cpt_taxonomy_tag_1,#cpt_taxonomy_tag_0').on(
            'change',
            function() {
                if ($('#cpt_taxonomy_tag_1').is(':checked')) {
                    $('.li_cpt_tag_name,.li_cpt_tag_slug').show()
                }
                if ($('#cpt_taxonomy_tag_0').is(':checked')) {
                    $('.li_cpt_tag_name,.li_cpt_tag_slug').hide()
                }
            }
        );
    },
    disable_tab: function($template, $tabs) {
        $ = jQuery;
        if ($.inArray($('.wp_timeline_template_name').val(), $template) !== -1) {
            $('.wp-timeline-setting-handle li').each(
                function() {
                    var hide = $(this).attr('data-show');
                    if (hide == $tabs) {
                        $(this).addClass('clickDisable');
                    }
                }
            );
        }
    },
};
jQuery(document).ready(function($) {
    if ($("input[name='read_more_link']:checked").val() == 1) {
        $('.read_more_wrap').show();
    } else {
        $('.read_more_wrap').hide();
    }
    if ($("input[name='advance_contents']:checked").val() == 1) {
        $('.advance_contents_tr.advance_contents_settings').show();
    } else {
        $('.advance_contents_tr.advance_contents_settings').hide();
    }
    if ($("input[name='post_link_type']:checked").val() == 1 && $("input[name='read_more_link']:checked").val() == 1) {
        $('.custom_link_url').show();
    } else {
        $('.custom_link_url').hide();
    }
    if( 'soft_block' == $('.wp_timeline_template_name').val() ) {
        jQuery('.blog-template-tr.wp-timeline-back-color-blog').hide();
        jQuery('.template-color').hide();
    } else {
        jQuery('.blog-template-tr.wp-timeline-back-color-blog').show();
        jQuery('.template-color').show();
    }
});

jQuery(document).ready(function() {
    // Function to update the hidden input with selected user IDs.
    function updateSelectedUsers() {
        var selected = [];
        jQuery('#timelinelayouttable tbody .check-column input[type=checkbox]:checked').each(function() {
            selected.push(jQuery(this).val());
        });
        jQuery('#role tbody .check-column input[type=checkbox]:checked').each(function() {
            selected.push(jQuery(this).val());
        });
        jQuery('#blk_timelinelayouttable_role').val(selected.join(','));
    }

    // Function to update bulk checkbox based on individual checkboxes.
    function updateBulkCheckbox() {
        var allChecked = jQuery('#timelinelayouttable tbody .check-column input[type=checkbox]').length === 
                         jQuery('#timelinelayouttable tbody .check-column input[type=checkbox]:checked').length;
        jQuery('#timelinelayouttable thead .check-column input[type=checkbox], #timelinelayouttable tfoot .check-column input[type=checkbox]').prop('checked', allChecked);
        var allCheckedRole = jQuery('#role tbody .check-column input[type=checkbox]').length === 
                             jQuery('#role tbody .check-column input[type=checkbox]:checked').length;
        jQuery('#role thead .check-column input[type=checkbox], #role tfoot .check-column input[type=checkbox]').prop('checked', allCheckedRole);
    }

    // Update individual checkboxes when the bulk checkbox is changed.
    jQuery('#timelinelayouttable thead .check-column input[type=checkbox], #timelinelayouttable tfoot .check-column input[type=checkbox]').on("change", function() {
        var isChecked = jQuery(this).prop('checked');
        jQuery('#timelinelayouttable tbody .check-column input[type=checkbox]').prop('checked', isChecked);
        updateSelectedUsers();
        updateBulkCheckbox();
    });
    jQuery('#role thead .check-column input[type=checkbox], #role tfoot .check-column input[type=checkbox]').on("change", function() {
        var isChecked = jQuery(this).prop('checked');
        jQuery('#role tbody .check-column input[type=checkbox]').prop('checked', isChecked);
        updateSelectedUsers();
        updateBulkCheckbox();
    });

    // Update bulk checkbox when an individual checkbox is changed.
    jQuery('#timelinelayouttable tbody .check-column input[type=checkbox]').on("change", function() {
        updateBulkCheckbox();
        updateSelectedUsers();
    });
    jQuery('#role tbody .check-column input[type=checkbox]').on("change", function() {
        updateBulkCheckbox();
        updateSelectedUsers();
    });

});

function isNumberKey(event){
    var charCode = (event.which) ?event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}