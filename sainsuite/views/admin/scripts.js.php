<script>
"use strict";

var SSuite = function() {
	// Elements
	var avatar;
	var offcanvas;
    var sidePanel;

    toastr.options = {
        "positionClass": "toast-bottom-right"
    };
    
    var $body = $('body'),
    sain_form_expire = '<?php echo gmt_to_local(time(), 'UTC') + GUI_EXPIRE;?>',
    sain_csrf_data = { '<?php echo $this->security->get_csrf_token_name();?>' : '<?php echo $this->security->get_csrf_hash();?>' };

	// Private functions
	var _initAside = function () {
		// Mobile offcanvas for mobile mode
		offcanvas = new SSOffcanvas('aside_panel', {
            overlay: true,
            baseClass: 'offcanvas-mobile',
			closeBy: 'aside_close',
            toggleBy: 'aside_mobile_toggle'
        });
	}
	var _initPanel = function () {
        var _element = SSUtil.getById('action_panel');
        var header = SSUtil.find(_element, '.offcanvas-header');
        var content = SSUtil.find(_element, '.offcanvas-content');

		sidePanel = new SSOffcanvas(_element, {
            overlay: true,
            baseClass: 'offcanvas',
            placement: 'right'
        });

        SSUtil.scrollInit(content, {
            disableForMobile: true,
            resetHeightOnDestroy: true,
            handleWindowResize: true,
            height: function() {
                var height = parseInt(SSUtil.getViewPort().height);

                if (header) {
                    height = height - parseInt(SSUtil.actualHeight(header));
                    height = height - parseInt(SSUtil.css(header, 'marginTop'));
                    height = height - parseInt(SSUtil.css(header, 'marginBottom'));
                }

                if (content) {
                    height = height - parseInt(SSUtil.css(content, 'marginTop'));
                    height = height - parseInt(SSUtil.css(content, 'marginBottom'));
                }

                height = height - parseInt(SSUtil.css(_element, 'paddingTop'));
                height = height - parseInt(SSUtil.css(_element, 'paddingBottom'));

                height = height - 2;

                return height;
            }
        });
	}

    var options = new function() {
        this.save_user_meta = function( key , value , user_id, callback ){
            var Objdata;
            eval( 'Objdata = { "' + key + '" : value, "user_id" : user_id }' );
            Objdata.gui_saver_expiration_time =	sain_form_expire;
            Objdata = _.extend( sain_csrf_data, Objdata );
            $.ajax({
                url : baseUrl+'admin/options/save_user_meta?mode=json',
                data: Objdata,
                type : 'POST',
                success	: function(){
                    if( typeof callback !== 'undefined' ) {
                        callback();
                    }
                }
            });
        }
        this.save = function( key , value , callback ){
            var Objdata;
            eval( 'Objdata = { "' + key + '" : value }' );
            Objdata.gui_saver_expiration_time =	sain_form_expire;
            Objdata = _.extend( sain_csrf_data, Objdata );
            $.ajax({
                url : baseUrl+'admin/options/save?mode=json',
                data: Objdata,
                type : 'POST',
                success	: function(){
                    if( typeof callback !== 'undefined' ) {
                        callback();
                    }
                }
            });
        }
    }
    
    var sainsuite = function(){
        // Dark Mode Switch @since v2.0
        var skin = new function() {
            var toggle = $('.dark-switch');
            var mode;
            if($body.hasClass('skin-'.<?=APPNAME;?>)){
                toggle.addClass('active');
                mode = 'skin-light';
            }else {
                toggle.removeClass('active');
                mode = 'skin-'.<?=APPNAME;?>;
            }
            toggle.on('click', function(e){
                e.preventDefault();
                $(this).toggleClass('active');
                $body.toggleClass('skin-'.<?=APPNAME;?>);
                options.save_user_meta( 'theme-skin' , mode , '<?php echo User::id();?>' );
            });
        }

        var mode = new function() {
            <?php
            global $User_Options;
            $skin = ($db_skin = riake('theme-skin', $User_Options)) ? $db_skin : 'skin-'.APPNAME;
            ?>

            var skin = "<?php echo ((in_array($skin, ['skin-light', 'skin-dark'])) ? $skin : 'skin-'.APPNAME);?>";
            $('#'+skin).prop("checked", true);
                        
            $('input[name="color-mode"]').on('change', function (e) {
                e.preventDefault();
                $body.removeClass(function (index, css) {
                    return (css.match (/\bskin-\S+/g) || []).join(' ');
                }).addClass($(this).attr('id'));
                options.save_user_meta( 'theme-skin' , $(this).attr('id') , '<?php echo User::id();?>' );
            });
        }

        if ( '<?php echo $this->events->apply_filters('fill_dev_mode', '') ?>' ) {
            $('.webdev_mode').removeClass('d-none');
        }
        
        var dev = new function() {
            var toggle = $('#dev_mode');
            var mode;
            toggle.on('click', function(e){
                if (toggle.is(":checked")) {
                    $('.webdev_mode').removeClass('d-none');
                    toastr.success('Developer Mode Active');
                    $( this ).attr( 'checked', false );
                    mode = '1';
                } else {
                    $('.webdev_mode').addClass('d-none');
                    toastr.success('Developer Mode Unactive');
                    $( this ).attr( 'checked', true );
                    mode = '0';
                }
                options.save( 'webdev_mode' , mode );
            });
        }
    };

    var cekClass = function() {
        // cek nav header bottom
        if ($("#ss_header div > div").length) {
            $('#ss_body').addClass('header-fixed');
            $('#ss_header').removeClass('d-none');
        }
        if ($(".navheader-nav").length) {
            $('.quick-search-form').addClass('pl-5 border-left');
        }

        // cek nav aside 
        if ($("#ss_aside_tab_1 .menu-item").length) {
            $('#ss_aside .aside-primary a[data-toggle="tab"]').removeClass('d-none');
            $('#aside_toggle').removeClass('d-none');
        }

        // cek condition table
        if ($("#ss_datatable").length && $("#aside_panel").length == 0) {
            $('#ss_header > div').addClass('container-fluid').removeClass('container');
            $('#ss_subheader > div').addClass('container-fluid').removeClass('container');
            $('#ss_data > div').addClass('container-fluid').removeClass('container');
            $('#ss_footer > div').addClass('container-fluid').removeClass('container');
        }

        // cek condition home
        if ($("#ss_home").length == 0) {
            $('#ss_subheader').removeClass('d-none');
        }
    }
    
    var aside_minimize = function () {
        var mode;
        if($body.hasClass('aside-minimize')){
            mode = 'aside-secondary-enabled';
            $body.addClass('aside-secondary-enabled').removeClass('aside-minimize');
            $('#aside_toggle').removeClass('aside-toggle-active');
        }else {
            mode = 'aside-minimize';
            $body.addClass('aside-minimize').removeClass('aside-secondary-enabled');
            $('#aside_toggle').addClass('aside-toggle-active');
        }
        options.save_user_meta( 'aside' , mode , '<?php echo User::id();?>' );
    }

    var menuAsidePrimary = function(){
        var asidePrimary = '#ss_aside .aside-primary a';
        var ss_aside_toggle = '#aside_toggle';

        $(asidePrimary).on('click', function(e) {
            var linkId = $(this).attr('href');

            localStorage.removeItem("menuHeaderPrimary");

            if ($(this).is('[data-toggle]') && $(this).data('toggle') == 'dropdown') {
                $(this).addClass('active');
            } 
            else if ($(this).is('[data-toggle]') && $(this).data('toggle') == 'tab') {
                localStorage.removeItem("menuDropdown");
                $(asidePrimary+'.active').removeClass('active');
                
                $(this).addClass('active');
                localStorage.setItem("menuAsidePrimary", linkId);
                aside_minimize();
            } 
            else {
                localStorage.removeItem("menuDropdown");
                $(asidePrimary+'.active').removeClass('active');

                var dropdownParent = $(this).parentsUntil('.dropdown').last().attr('id');
                if (typeof dropdownParent !== "undefined") {
                    $(asidePrimary+'[data-target="'+ dropdownParent +'"]').addClass("active");
                    localStorage.setItem("menuDropdown", dropdownParent);
                }

                $(this).addClass('active');
                localStorage.setItem("menuAsidePrimary", linkId);
                $body.addClass('aside-minimize').removeClass('aside-secondary-enabled');
                $('#aside_toggle').addClass('aside-toggle-active');
                options.save_user_meta( 'aside' , 'aside-minimize' , '<?php echo User::id();?>' );
            }
        });

        $(ss_aside_toggle).on('click', function(e) {
            localStorage.setItem("menuAsidePrimary", 'app');
            $('#ss_aside .aside-primary a[href="app"]').addClass('active');
            aside_minimize();
        });

        var menuDropdown = localStorage.getItem("menuDropdown");
        if (menuDropdown != null) {
            $(asidePrimary+'[data-target="'+ menuDropdown +'"]').addClass("active");
        }
        
        var menuAside = localStorage.getItem("menuAsidePrimary");
        if (menuAside != null) {
            $(asidePrimary+'[href="'+ menuAside +'"]').addClass("active");
        }
    }
    
    var menuAsideSecondary = function(){
        var asideSecondary = '#ss_aside_menu .menu-nav li a';
        var _link = '.menu-link',
            _currentURL = window.location.href,
            fileName = _currentURL.substring(0, (_currentURL.indexOf("#") == -1) ? _currentURL.length : _currentURL.indexOf("#")), 
            fileName = fileName.substring(0, (fileName.indexOf("?") == -1) ? fileName.length : fileName.indexOf("?"));
            
        $(asideSecondary).on('click', function(e) {
            var linkId = $(this).attr('href');

            var linkSubmenu = $(this).parentsUntil('.menu-item-submenu').closest("li").children('.menu-toggle').attr('href') ;
            if ( linkSubmenu != null && linkSubmenu != localStorage.getItem("menuAsideSecondarySubmenu") ) {
                localStorage.removeItem("menuAsideSecondarySubmenu");
            }
            else if ( linkSubmenu == null ) {
                localStorage.removeItem("menuAsideSecondarySubmenu");
            }

            if ( $(this).hasClass("menu-toggle") ) {
                localStorage.setItem("menuAsideSecondarySubmenu", linkId);
            }
            else {
                localStorage.removeItem("menuAsideSecondary");
                localStorage.setItem("menuAsideSecondary", linkId);
            }
        });
        
        var menuSecondary = localStorage.getItem("menuAsideSecondary");
        if (menuSecondary != null) {
            $(asideSecondary+'[href="'+ menuSecondary +'"]').parent().addClass("menu-item-active");
        }
        
        var menuSubmenu = localStorage.getItem("menuAsideSecondarySubmenu");
        if (menuSubmenu != null) {
            $(asideSecondary+'[href="'+ menuSubmenu +'"]').parent().addClass("menu-item-open");
        }

        if (fileName.match('page404')) {
            localStorage.removeItem("menuMobilePrimary");
            localStorage.removeItem("menuHeaderPrimary");
            localStorage.removeItem("menuAsidePrimary");
            localStorage.removeItem("menuAsideSecondarySubmenu");
            localStorage.removeItem("menuAsideSecondary");
            localStorage.removeItem("menuDropdown");
        }

        // $(_link).each(function() {
        //     var self = $(this), _self_link = self.attr('href');
        //     if (fileName.match(_self_link)) {
        //         self.closest("li").addClass('menu-item-active').parents().closest("li").addClass("menu-item-open");
        //         self.closest("li").children('.menu-submenu').addClass('menu-item-open');
        //         self.parents().closest("li").children('.menu-submenu').addClass('menu-item-open');
        //     } else {
        //         self.closest("li").removeClass('menu-item-active').parents().closest("li:not(.menu-item-active)").removeClass("active");
        //     }
        // });
    };
    
    var menuMobilePrimary = function(){
        var mobilePrimary = '#ss_header_mobile a',
            _currentURL = window.location.href;

        $(mobilePrimary).on('click', function(e) {
            var linkId = $(this).attr('href');

            if ($(this).is('[data-toggle]') && $(this).data('toggle') == 'dropdown') {
                $(this).addClass('active');
            } 
            else {

                var dropdownParent = $(this).parentsUntil('.dropdown').last().attr('id');
                if (typeof dropdownParent !== "undefined") {
                    $(mobilePrimary+'[data-target="'+ dropdownParent +'"]').addClass("active");
                    localStorage.setItem("menuDropdown", dropdownParent);
                }

                localStorage.setItem("menuMobilePrimary", linkId);
            }
        });

        var menuDropdown = localStorage.getItem("menuDropdown");        
        var menuMobile = localStorage.getItem("menuMobilePrimary");
        if (menuMobile != null) {
            $(mobilePrimary+'[href="'+ menuMobile +'"]').addClass("active");
        }
    }

    var menuHeaderPrimary = function() {
        var headerPrimary = '#ss_header .navheader-nav a',
            _currentURL = window.location.href,
            fileName = _currentURL.substring(0, (_currentURL.indexOf("#") == -1) ? _currentURL.length : _currentURL.indexOf("#")), 
            fileName = fileName.substring(0, (fileName.indexOf("?") == -1) ? fileName.length : fileName.indexOf("?"));

        $(headerPrimary).on('click', function(e) {
            var linkId = $(this).attr('href');
            $(headerPrimary+'.active').removeClass('active');

            $(this).addClass('active');

            localStorage.setItem("menuHeaderPrimary", linkId);
        });

        var menuHeader = localStorage.getItem("menuHeaderPrimary");
        if (menuHeader != null && menuHeader == _currentURL || fileName.match(menuHeader)) {
            $(headerPrimary+'[href="'+ menuHeader +'"]').addClass("active");
        } else {
            $(headerPrimary).first().addClass("active");
        }
    }

    var accordion = function() {
        var accordionPrimary = '#accordion .card-header';

        $(accordionPrimary).on('click', function(e) {
            var linkId = $(this).next().attr('id');
            localStorage.setItem("accordionHeaderPrimary", linkId);
        });

        var accordionHeader = localStorage.getItem("accordionHeaderPrimary");
        if (accordionHeader != null) {
            $('#'+accordionHeader).addClass('show');
        }
        else {
            $('#collapse1').addClass('show');
        }
    }

    var setloader = new function(){
        this.int =	0;
        this.timeOutToClose;
        this.show =	function(){
            this.int++;
            if( $( '#canvasLoader' ).length > 0 ) {
                clearTimeout( this.timeOutToClose );
            } else {
                if( this.int == 1 ) {
                    if( $( '#sain-spinner' ).length > 0 ) {
                        var cl = new CanvasLoader( 'sain-spinner' );
                        cl.setColor('#ffffff'); // default is '#000000'
                        cl.setDiameter(39); // default is 40
                        cl.setDensity(56); // default is 40
                        cl.setSpeed(3); // default is 2
                        cl.show(); // Hidden by default
                        $('#sain-spinner').fadeIn(500);
                    }
                }
            }
        }
        this.hide =	function(){
            this.int--;
            if( this.int == 0 ){
                this.timeOutToClose	= setTimeout( function(){
                    $('#sain-spinner').fadeOut(500, function(){
                        $(this).html('').show();
                    })
                }, 500 );
            }
        }
    };

    // Form
    var setDatePicker = function (){
        if ($(".datepicker").length) {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                clearBtn: true,
                autoclose: true
            }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
        }
        if ($(".yearpicker").length) {
            $(".yearpicker").datepicker({
                format: "yyyy",
                maxViewMode: "years",
                minViewMode: "years",
                todayHighlight: true,
                autoclose: true
            }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
        }
    }
    var setDateRangePicker = function (input1, input2){
        $(input1).datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        }).on("change", function(){
            $(input2).val("").datepicker('setStartDate', $(this).val());
        }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});

        $(input2).datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            orientation: "bottom right"
        }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
    }
    var setSelectpicker = function () {
        if ($(".ss-selectpicker").length) {
            $('.ss-selectpicker').selectpicker();
        }
    }
    var setSelects = function () {
        if ($(".select2").length) {
            $('.select2').select2({
                placeholder: "Select a state",
                allowClear: true
            });
        }
    }

    // Public methods
    return {
        init: function() {            
			_initAside();
			_initPanel();
            cekClass();
            sainsuite();
            menuAsidePrimary();
            menuMobilePrimary();
            menuHeaderPrimary();
            menuAsideSecondary();
            accordion();
            setDatePicker();
            setSelectpicker();
            setSelects();
            $( document ).ajaxComplete(function() {
                setloader.hide();
            });
            $( document ).ajaxError(function() {
                setloader.hide();
            });
            $( document ).ajaxSend(function() {
                setloader.show();
            });

            <?php if ($this->session->flashdata('info_message') != ""):?>
            toastr.info("<?php echo $this->session->flashdata("info_message");?>");
            <?php endif;?>

            <?php if ($this->session->flashdata('error_message') != ""):?>
            toastr.error("<?php echo $this->session->flashdata("error_message");?>");
            <?php endif;?>

            <?php if ($this->session->flashdata('flash_message') != ""):?>
            toastr.success("<?php echo $this->session->flashdata("flash_message");?>");
            <?php endif;?>

            <?php if ( validation_errors() ) : ?>
            toastr.error(<?php echo json_encode(validation_errors('<p class="mb-0">'));?>);
            <?php endif; ?>

            <?php if ($this->notice->output_notice(true)):?>
            toastr.error("<?php echo $this->notice->output_notice(true);?>");
            <?php endif;?>

            <?php if (notice_from_url() != ""):?>
            toastr.success("<?php echo notice_from_url();?>");
            <?php endif;?>

            //close side panel
            $('#action_panel').on('click',".action_close",function () {
                sidePanel.hide();
            });
            $('#aside_panel').on('click',".action_close",function () {
                offcanvas.hide();
            });
            // TAB
            if($('#Tab').length>0){
                $('#Tab').responsiveTabs({
                    animation: 'slide',
                    startCollapsed: 'accordion',
                    startCollapsed: false // Start with the panels collapsed
                });
            };
        },
        isJson: function(item) {
            item = typeof item !== "string"
                ? JSON.stringify(item)
                : item;

            try {
                item = JSON.parse(item);
            } catch (e) {
                return false;
            }

            if (typeof item === "object" && item !== null) {
                return true;
            }

            return false;
        },
        getSidePanel: function() {
            return sidePanel;
        },
        initPanel: function() {
            return _initPanel();
        }
    };
}();

var suiteApp = angular.module( 'suiteApp', <?php echo json_encode( ( Array ) $this->events->apply_filters( 'fill_dependencies', array() ) );?> );
var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

function checkRequiredFields(btn) {
    
    var form = $('form.required-form');

    var required = 1;
    form.find('input, select').each(function(){
        if($(this).prop('required')) {
            if ($(this).val() === "") { required = 0; }
        }
    });

    if (required === 1) {
        form.submit(); // Submit form
    } else {
        toastr.error("<?php _e('please fill all the required fields'); ?>");
    }
}

function deleteConfirmation(el) {
    var url = $(el).data('url');
    var header = $(el).data('head');
    Swal.fire({
        title: (header ? header : 'Would you like to delete all ?'),
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        <?php if (isset($namespace) && ! User::is_allowed('delete.'.$namespace)) { ?>
        Swal.fire(
            "Cancelled",
            "Anda tidak memiliki izin hapus data :)",
            "error"
        )
        return
        <?php } ?>

        if (result.value) {
            if(url){
                $.ajax({
                    url: url,
                    type: 'POST',
                    beforeSend: function() {
                        if ( $(el).closest('tr').length === 0 ) {
                            SSApp.block($(el).closest('div.card'), {
                                overlayColor: '#000000',
                                state: 'primary',
                                message: 'Processing...'
                            });
                        } 
                    },
                    success: function(data) {
                        if ( $(el).closest('tr').length === 0 ) {
                            $(el).closest('div.card').fadeOut(1000,function(){
                                location.reload();
                            });
                        } 
                        else {
                            $(el).closest('tr').fadeOut(1000,function(){
                                $('#ss_datatable').SSDatatable('reload');
                            });
                        }
                    }
                });
            }
            else {
                // Get value from checked checkboxes
                var ids_arr = [];
                $("input[type=checkbox]:checked").each(function(){
                    ids_arr.push($(this).val());
                });

                // Array length
                var length = ids_arr.length;
                $.ajax({
                    url: baseUrl+'admin'+<?=(isset($namespace)) ? "'/".$namespace."'" : "'/'";?>+'delete',
                    type: 'post',
                    data: {ids: ids_arr},
                    success: function(data) {
                        // Remove <tr>
                        $("input[type=checkbox]:checked").each(function(){
                            $(this).closest('tbody tr').fadeOut(1000,function(){
                                $('#ss_datatable_group_action_form').collapse('hide');
                                $('#ss_datatable').SSDatatable('reload');
                            });
                        });
                    }
                });
            }
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Anda membatalkan hapus data :)",
                "error"
            )
        }
    });
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

jQuery(document).ready(function () {
    SSuite.init();
});
</script>