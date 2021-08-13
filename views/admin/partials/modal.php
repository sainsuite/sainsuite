<!-- (Large Modal)-->
<div class="modal fade" id="large-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ss ss-close"></i>
                </button>
            </div>
            <div class="modal-body">
                ....
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModal-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ss ss-close"></i>
                </button>
            </div>
            <div class="modal-body">
                ....
            </div>
        </div>
    </div>
</div>

<!-- Scrollable modal -->
<div class="modal fade" id="scrollable-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ss ss-close"></i>
                </button>
            </div>
            <div class="modal-body" data-scroll="true" data-height="300">
                ....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><?php _e("close"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Info Alert Modal -->
<div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <i class="ss ss-outline-info icon-5x text-info"></i>
                    <h4 class="mt-2"><?php _e("heads up"); ?>!</h4>
                    <p class="mt-3"><?php _e("are you sure"); ?>?</p>
                    <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal"><?php _e("cancel"); ?></button>
                    <a href="#" id="update_link" class="btn btn-danger font-weight-bold"><?php _e("continue"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Compose-->
<div class="modal modal-sticky modal-sticky-lg modal-sticky-bottom-right" id="ss_compose" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <!--begin::Header-->
                <div class="d-flex align-items-center justify-content-between py-5 pl-8 pr-5">
                    <h5 class="font-weight-bold m-0 modal-title">....</h5>
                    <div class="d-flex ml-2">
                        <span class="btn btn-clean btn-sm btn-icon" data-dismiss="modal">
                            <i class="ss ss-close icon-1x"></i>
                        </span>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Footer-->
                <div class="row py-5 pl-8 pr-5">
                    <!--begin::Actions-->
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="extension_zip" required/>
                                    <label class="custom-file-label overflow-hidden" for="customFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" onclick="checkRequiredFields(this)" class="btn btn-primary font-weight-bolder mr-1">
                                        <span class="position-relative"><i class="fa fa-upload"></i> <?php echo __('Upload');?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

<script type="text/javascript">
    function confirm_modal(delete_url)
    {
        $('#alert-modal').modal('show');
        document.getElementById('update_link').setAttribute('href' , delete_url);
    }

    function composeModal(url, header)
    {
        // SHOWING AJAX PRELOADER IMAGE
        $('#ss_compose .modal-title').html(header);
        $('#ss_compose .form').attr('action', url);
        // LOADING THE AJAX MODAL
        $('#ss_compose').modal('show', {backdrop: 'true'});
    }

    function showAjaxModal(url, header)
    {
        // SHOWING AJAX PRELOADER IMAGE
        $('#scrollable-modal .modal-body').html('<i class="ss ss-plus"></i>');
        $('#scrollable-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        $('#scrollable-modal').modal('show');

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
                $('#scrollable-modal .modal-body').html(response);
                $('#scrollable-modal .modal-title').html(header);
            }
        });
    }

    function showLargeModal(url, header)
    {
        // SHOWING AJAX PRELOADER IMAGE
        $('#large-modal .modal-body').html('<i class="ss ss-plus"></i>');
        $('#large-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        $('#large-modal').modal('show', {backdrop: 'true'});

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
                $('#large-modal .modal-body').html(response);
                $('#large-modal .modal-title').html(header);
            }
        });
    }

    function showModal(url, header)
    {
        // SHOWING AJAX PRELOADER IMAGE
        $('#showModal-modal .modal-body').html('<i class="ss ss-plus"></i>');
        $('#showModal-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        $('#showModal-modal').modal('show', {backdrop: 'true'});

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
                $('#showModal-modal .modal-body').html(response);
                $('#showModal-modal .modal-title').html(header);
            }
        });
    }
</script>
