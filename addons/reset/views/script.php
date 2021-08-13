<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */
?>

<script>
var Resets = function() {
    var askReset = function() {
        Swal.fire({
            title: '<?php echo _s( 'Confirm Your Action', 'reset' );?>',
            type: 'info',
            html: `<?php echo _s( 'While it\'s enabled, <br> we to delete all your data.', 'reset');?>`,
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, submit!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn font-weight-bold btn-primary",
                cancelButton: "btn font-weight-bold btn-default"
            }
        }).then(function (result) {
            if (result.value) {
                location.href = '<?php echo site_url(['admin', 'reset']) . '?reset-process=confirm';?>';
            } else if (result.dismiss === 'cancel') {
                Swal.fire({
                    title: '<?php echo _s( 'Disable Reset On Active', 'reset' );?>',
                    type: 'info',
                    html: `<?php echo _s( 'You don\'t wish to reset right now ?', 'reset');?>`,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-primary",
                    }
                });
            }
        });
    }

    return {
        init: function() {

            $('#button_reset').on('click', function () {
                askReset();
            })
        },
    };
}();

jQuery(document).ready(function() {
    Resets.init();
});
</script>