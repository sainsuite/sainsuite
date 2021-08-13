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
$addons = $this->events->apply_filters('fill_folder_addons', MY_Addon::get());
if ($addons) : 
    $groups = array();
    foreach (force_array($addons) as $addon => $_addon) 
    {
        // group subarrays by a column value
        $groups[$_addon[ 'application' ]['package']][$addon] = $_addon;
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
            if (isset($_group[ 'application' ][ 'namespace' ]) ) {
                $addon_namespace = $_group[ 'application' ][ 'namespace' ];
                $addon_version = $_group[ 'application' ][ 'version' ];
                $last_version = riake('migration_' . $addon_namespace, $Options);
                $color = ($_group[ 'application' ][ 'package' ] == 'addkit') ? 'bg-light-primary' : 'bg-secondary';
                ?>
                <div class="col-6 col-lg-3 col-xxl-2">
                    <div class="card card-custom gutter-b card-stretch border border-1 mb-4" data-card="true" data-card-tooltips="false">     
                        <div class="card-header min-h-20px d-flex align-items-center justify-content-between px-2 py-2">
                            <div class="text-dark m-0 text-hover-primary ml-2">
                                <span class="font-weight-bolder">
                                <?php echo isset($_group[ 'application' ][ 'name' ]) ? $_group[ 'application' ][ 'name' ] : __('Addons');?>
                                </span> | 
                                <?php echo 'v' . (isset($_group[ 'application' ][ 'version' ]) ? $_group[ 'application' ][ 'version' ] : 0.1);?>
                            </div>
                            <div>
                                <?php $this->events->do_action('do_menu_addon_header', $_group) ?>
                            </div>
                        </div>   
                        <div class="card-body bgi-no-repeat p-4 min-h-50px <?php echo $color ;?>">
                            <p><?php echo $_group[ 'application' ][ 'description' ];?></p>
                        </div> 
                        <div class="p-1 min-h-40px d-flex justify-content-between align-items-center <?php echo $color ;?>">
                            <div class="d-flex align-items-center">
                                <?php if (User::in_group('master') ): ?>
                                <a href="<?php echo site_url(array( 'admin', 'addons', 'extract', $addon_namespace ));?>" 
                                    class="btn btn-icon btn-sm btn-info ml-1 webdev_mode d-none btn-ajax" 
                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php _e('Extract');?>">
                                    <i class="fas fa-download"></i>
                                </a>
                                <?php endif; ?>
                                
                                <?php if ( $this->events->apply_filters('fill_addon_toolbar', $_group) && ! $_group[ 'application' ][ 'readonly' ]) :
                                    // Migration
                                    $hasMigration = MY_Addon::migration_files( 
                                        $addon_namespace, 
                                        $last_version, 
                                        $addon_version
                                    );
                                    if( $hasMigration && User::in_group('master')):?>
                                    <a href="<?php echo site_url([ 'admin', 'addons', 'migrate', $addon_namespace, $last_version ]);?>" 
                                        class="btn btn-icon btn-sm btn-light-dark ml-1 btn-ajax" 
                                        data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php _e('Migrate');?>">
                                        <i class="fas fa-database"></i>
                                    </a>
                                    <?php endif;?>

                                    <?php if (! MY_Addon::is_active($addon_namespace, true)) {?>
                                        <?php if ( User::is_allowed('manage.core') ) : ?>
                                        <a href="#" class="btn btn-icon btn-sm btn-danger ml-2 btn-ajax" 
                                            data-url="<?php echo site_url(array( 'admin', 'addons', 'remove', $addon_namespace )); ?>" 
                                            data-head="<?php _e( 'Would you like to delete this addon?');?>" 
                                            data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"
                                            onclick="deleteConfirmation(this)">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </a>
                                        <?php endif;?>
                                        <a href="<?php echo site_url(array( 'admin', 'addons', 'enable', $addon_namespace )); ?>" 
                                            class="btn btn-success btn-sm text-uppercase font-weight-bolder ml-2 btn-ajax" >
                                            Enable
                                        </a>
                                    <?php } else {?>
                                        <a href="<?php echo site_url(array( 'admin', 'addons', 'disable', $addon_namespace )); ?>" 
                                            class="text-danger text-uppercase font-weight-bolder ml-2 btn-ajax" >
                                            Disable
                                        </a>
                                    <?php };?>
                                
                                <?php endif;?>
                            </div>

                            <div class="d-flex align-items-center">
                            <?php $this->events->do_action('do_menu_addon_footer', $_group) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            else {
                // $found = false;
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
    <p>You have not created any addons.</p>
</div>';
endif;
?>