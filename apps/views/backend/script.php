<script>
    /**
     * Option
     */
    var sain =	new Object;
    sain.form_expire = '<?php echo gmt_to_local(time(), 'UTC') + GUI_EXPIRE;?>';
    sain.user =	{ id : '<?php echo User::id();?>' }
    sain.dashboard_url = '<?php echo site_url(array( 'admin' ));?>';
    sain.csrf_data = { '<?php echo $this->security->get_csrf_token_name();?>' : '<?php echo $this->security->get_csrf_hash();?>' };
    sain.suite = function(){
        $this =	this;
        this.sidebar =	new function() {
            var menuAside = localStorage.getItem("menuAside");
            var url = window.location.href;
            $('#kt_aside').on('click', '.aside-primary a', function(e) {
                var linkId = $(this).attr('href');
                var target = $(this).data('target');
                var toggle = $(this).data('toggle');

                if (menuAside != null) {
                    if (menuAside == target) { 
                        e.preventDefault();
                        return
                    } else if (menuAside == linkId && url.indexOf(linkId) > -1) { 
                        e.preventDefault();
                        return
                    }
                } 

                if(toggle == null) {
                    $this.options.save( 'dashboard-sidebar' , 'aside-minimize' , sain.user.id );
                } 
            });
            $('#kt_aside').on('click', '.aside-secondary a', function(e) {
                var linkId = $(this).attr('href');
                if (menuAside != null && menuAside == linkId && url.indexOf(linkId) > -1) { 
                    e.preventDefault();
                    return;
                } 
                $this.options.save( 'dashboard-sidebar' , 'aside-secondary-enabled' , sain.user.id );
            });
        }

        this.options =	new function() {
            this.save =	function( key , value , user_id, callback ){
                eval( 'Objdata = { "' + key + '" : value, "user_id" : user_id }' );
                Objdata.gui_saver_expiration_time =	sain.form_expire;
                // Objdata = _.extend( sain.csrf_data, Objdata );
                $.ajax({
                    url : sain.dashboard_url + '/options/save_user_meta?mode=json',
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
    };
    sain.loader = new function(){
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
    }

    $(document).ready(function(){
        "use strict";
        new sain.suite();

        $( document ).ajaxComplete(function() {
            sain.loader.hide();
        });
        $( document ).ajaxError(function() {
            sain.loader.hide();
        });
        $( document ).ajaxSend(function() {
            sain.loader.show();
        });
    });
    
    /**
    * Introducing Angular
    **/
    var App = angular.module( 'SainSuite', <?php echo json_encode( ( Array ) $this->events->apply_filters( 'admin_dependencies', array() ) );?> );
</script>