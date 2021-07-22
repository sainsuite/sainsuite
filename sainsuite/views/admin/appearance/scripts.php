<script>
"use strict";

/*============================================
Appearance
==============================================*/
// Class Initialization
jQuery(document).ready(function() {
        //WHEN CLICK CONFIRM BUTTON
        $('.btn-ajax').on('click', function () {
            var btn = $(this);
            SITApp.block(btn.closest('div.card'), {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                SITApp.unblock(btn.closest('div.card'));
            }, 500);
        });
});
</script>