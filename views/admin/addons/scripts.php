<script>
"use strict";

/*============================================
Addons
==============================================*/
// Class Initialization
jQuery(document).ready(function() {
        //WHEN CLICK CONFIRM BUTTON
        $('.btn-ajax').on('click', function () {
            var btn = $(this);
            SSApp.block(btn.closest('div.card'), {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                SSApp.unblock(btn.closest('div.card'));
            }, 500);
        });
});
</script>