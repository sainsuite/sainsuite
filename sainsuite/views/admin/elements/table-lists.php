<?php if ( count( force_array( riake('tbody', $_item ) ) ) > 0) : ?>
    <?php foreach( force_array( riake( 'tbody', $_item ) ) as $index) : ?>
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="btn-group">
            <div class="card-body">
                <!--begin::Top-->
                <div class="d-flex flex-wrap align-items-center">
                    <!--begin::Pic-->
                    <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                        <?php echo $index[0]; ?>
                    </div>
                    <!--end::Pic-->

                    <!--begin: Info-->
                    <div class="d-flex flex-column my-lg-0 my-2 pr-3">
                        <div class="d-flex flex-wrap my-2">
                            <!--begin::Title-->
                            <?php echo $index[1];?> <i class="flaticon2-correct text-success icon-md ml-2"></i>
                            <!--end::Title-->
                        </div>

                        <div class="d-flex flex-column flex-md-row flex-wrap my-2">
                            <!--begin::Contacts-->
                            <?php echo $index['status'];?>
                            <!--end::Contacts-->
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Top-->
            </div>
                    
            <div class="d-flex align-items-center py-lg-0 py-2">
                <div class="btn-group-vertical min-h-100">
                <?php echo $index['action'];?>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <?php endforeach;?>
<?php else : ?>
    <div class="text-center">
        <img class="w-150px mb-5" src="<?php echo asset_url('svg/not_found.svg'); ?>"/>
        <br>
        <span class="text-uppercase font-weight-bold text-muted">WELL, THIS IS A BIT AWKWARD.</span> <br>
        <span>This space doesn't have a homepage so there's nothing to display here.</span>
    </div>
<?php endif;?>