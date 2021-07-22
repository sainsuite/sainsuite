<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Start header -->
<header class="header-nav-center header_ch_left active-dark" id="myNavbar">
    <div class="container">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light px-sm-0">
            <a class="navbar-brand" href="<?php echo site_url();?>">
                <img class="logo" src="<?php echo $this->events->apply_filters( 'fill_apps_logo', '' ); ?>" alt="<?php echo riake('site_name', options(APPNAME)); ?>" />
            </a>

            <button class="navbar-toggler menu ripplemenu" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg viewBox="0 0 64 48">
                <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
                </svg>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="nav_account ml-auto">
                    <?php if (User::is_loggedin()) : ?>
                    <a href="<?=site_url('admin')?>" class="btn btn_demo3 btn_sm_primary rounded-pill">
                        <?php echo User::get()->username;?>
                    </a>
                    <a href="<?=site_url('logout')?>" class="btn btn_sm_primary border-0 effect-letter bg-dark c-white rounded-pill">
                        Sign Out
                    </a>
                    <?php else : ?>
                    <a href="https://github.com/saintekno" class="btn btn_demo3 btn_sm_primary rounded-pill">
                        Download
                    </a>
                    <a href="<?=site_url('login')?>" class="btn btn_demo2 btn_sm_primary effect-letter bg-dark c-white rounded-pill">
                        Try it for free
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
    <!-- end container -->
</header>
<!-- End header -->