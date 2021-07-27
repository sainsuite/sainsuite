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

global $Options;

$found = true;
$themes = $this->events->apply_filters('fill_folder_themes', Theme::get());
if ($themes) :
    $groups = array();
    foreach (force_array($themes) as $theme => $_theme) 
    {
        // group subarrays by a column value
        $groups[$_theme[ 'theme' ]['package']][$theme] = $_theme;
    }

    echo '<div class="accordion accordion-light" id="accordion">';
    $i = 1;
    foreach ($groups as $group => $groupx) 
    {
        echo '<div class="card gutter-b">';
        echo '
        <div class="card-header card-header-light" id="heading'.$i.'" data-toggle="collapse" data-target="#collapse'.$i.'">
            <div class="card-title pb-3 d-flex flex-column align-items-start">
                <div class="card-label">By '.$group.'</div>
            </div>
        </div>';
        echo '
        <div id="collapse'.$i.'" class="collapse show" data-parent="#accordion">
            <div class="card-body px-0">';
        echo '<div class="row">';
        foreach ( $groupx as $_group ) 
        {            
            if (isset($_group[ 'theme' ][ 'namespace' ])) {
                $theme_namespace = $_group[ 'theme' ][ 'namespace' ];
                $theme_version = $_group[ 'theme' ][ 'version' ];
                $color = ($_group[ 'theme' ][ 'package' ] == 'themekit') ? 'bg-light-primary' : 'bg-secondary';
                ?>
                <div class="col-6 col-lg-3 col-xxl-2">
                    <div class="card card-custom gutter-b card-stretch border border-1 mb-4" data-card="true" data-card-tooltips="false">     
                        <div class="card-header min-h-20px d-flex align-items-center justify-content-between px-2 py-2">
                            <div class="text-dark m-0 text-hover-primary ml-2">
                                <span class="font-weight-bolder">
                                <?php echo isset($_group[ 'theme' ][ 'name' ]) ? $_group[ 'theme' ][ 'name' ] : __('themes');?>  
                                </span> | 
                                <?php echo 'v' . $theme_version;?>
                            </div>
                            <div>
                                <?php if (Theme::is_active($theme_namespace, true)) : ?>
                                <span class="label label-inline label-success ml-2" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Theme Active">
                                    active
                                </span>
                                <?php endif; ?>
                                <?php $this->events->do_action('do_menu_theme_header', $_group) ?>
                            </div>
                        </div>   
                        <div class="card-body bgi-no-repeat p-4 min-h-50px <?php echo $color ;?>">
                            <p><?php echo $_group[ 'theme' ][ 'description' ];?></p>
                        </div> 
                        <div class="p-2 min-h-40px d-flex justify-content-between align-items-center <?php echo $color ;?>">
                            <div class="d-flex">
                                <?php if ( $this->events->apply_filters('fill_theme_toolbar', $_group) ) : ?>
                                    <?php if (User::in_group('master')):?>
                                    <a href="<?php echo site_url(array( 'admin', 'appearance', 'extract', $theme_namespace ));?>" 
                                        class="btn btn-icon btn-sm btn-info ml-1 webdev_mode d-none">
                                        <i class="fas fa-download"></i> 
                                    </a>
                                    <?php endif; ?>
                                    <?php if (! Theme::is_active($theme_namespace, true) && $_group[ 'theme' ][ 'namespace' ] != 'default') : ?>
                                        <?php if ( User::is_allowed('delete.themes') && User::is_allowed('manage.core') ) : ?>
                                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder text-uppercase ml-2"
                                            data-head="<?php _e( 'Would you like to delete this theme?');?>"
                                            data-url="<?php echo site_url(array( 'admin', 'appearance', 'remove', $theme_namespace )); ?>"
                                            onclick="deleteConfirmation(this)">
                                            <i class="fa fa-trash p-0"></i>
                                        </a>
                                        <?php endif;?>
                                    <?php endif; ?>
                                    
                                    <?php if (! Theme::is_active($theme_namespace, true)) : ?>
                                    <a href="<?php echo site_url(array( 'admin', 'appearance', 'enable', $theme_namespace ));?>" 
                                        class="btn btn-sm btn-primary font-weight-bolder text-uppercase ml-2 btn-ajax" 
                                        data-action="enable">
                                        enable
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>

                            <div class="d-flex align-items-center">
                            <?php $this->events->do_action('do_menu_theme_footer', $_group) ?>
                            </div>
                        </div>   
                    </div>
                </div>
                <?php
            }
            else {
                $found = false;
            }
        }
        echo '</div>';
        echo '</div></div>';
        echo '</div>';
        $i++;
    }
    echo '</div>';
else :
    $found = false;
endif;

if(! $found) :
echo '
<div class="d-flex flex-column flex-center py-10">
    <p>You have not created any themes.</p>
</div>';
endif;
?>
<!--end::Body-->