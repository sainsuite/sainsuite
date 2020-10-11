<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <h3 class="font-weight-bold mb-10 text-dark">
            <?php echo sprintf( __( 'You\'re using <b>%s</b> %s' ), get( 'app_name' ), get('version') );?>
        </h3>
        <div class="font-weight-nromal font-size-lg mb-6">
            <?php if ($check) : ?>
            <h6><?php echo sprintf(__('%s : %s is available'), get('app_name'), riake('title', $check[0])); ?></h6>
            <p><?php echo $this->markdown->parse(riake('content', $check[0])); ?></p>
            
            <a class="btn btn-primary" href="<?php echo site_url(array( 'admin', 'about', 'core', riake('version', $check[0]) )); ?>">
                <?php _e('Click Here to Update'); ?>
            </a>
            <?php else : ?>
            <h6><?php _e("up to date"); ?></h6>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table table-light table-light-success">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="table-center">Free</th>
                            <th class="table-center">Premium</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold table-row-title">Unlimited Users
                            </td>
                            <td class="table-center"><span
                                    class="svg-icon svg-icon-success">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Double-check.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24"
                                        version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                opacity="0.3"
                                                transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) " />
                                            <path
                                                d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span></td>
                            <td class="table-center"><span
                                    class="svg-icon svg-icon-success">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Double-check.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24"
                                        version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                opacity="0.3"
                                                transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) " />
                                            <path
                                                d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="font-weight-bold table-row-title">End Product
                                Usage</td>
                            <td class="table-center"><span
                                    class="svg-icon svg-icon-danger">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Close.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24"
                                        version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                fill="#000000">
                                                <rect x="0" y="7" width="16" height="2"
                                                    rx="1" />
                                                <rect opacity="0.3"
                                                    transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) "
                                                    x="0" y="7" width="16" height="2"
                                                    rx="1" />
                                            </g>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span></td>
                            <td class="table-center"><span
                                    class="svg-icon svg-icon-success">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Double-check.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24"
                                        version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                opacity="0.3"
                                                transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) " />
                                            <path
                                                d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon--></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>

        <div class="font-weight-nromal font-size-lg mb-6">
        </div>
    </div>
    <div class="col-lg-2"></div>
</div>